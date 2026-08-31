<?php

namespace App\Services\Cv;

class CvWriterPanel
{
    public function configuration(): array
    {
        return [
            'openai' => $this->openAiConfig() !== null,
            'anthropic' => $this->anthropicConfig() !== null,
            'gemini' => $this->geminiConfig() !== null,
        ];
    }

    /**
     * @return array{content:array,panel:array,lead_writer:string}
     */
    public function write(string $cvText, array $context = []): array
    {
        $drafts = [];
        $panel = [];

        foreach (['openai', 'anthropic', 'gemini'] as $provider) {
            try {
                $config = match ($provider) {
                    'openai' => $this->openAiConfig(),
                    'anthropic' => $this->anthropicConfig(),
                    'gemini' => $this->geminiConfig(),
                };
                if ($config === null) {
                    $panel[$provider] = ['status' => 'not_configured'];
                    continue;
                }
                $draft = match ($provider) {
                    'openai' => $this->callOpenAi($config, $cvText, $context),
                    'anthropic' => $this->callAnthropic($config, $cvText, $context),
                    'gemini' => $this->callGemini($config, $cvText, $context),
                };
                $drafts[$provider] = $this->normalise($draft['content'] ?? []);
                $panel[$provider] = [
                    'status' => 'completed',
                    'model' => $draft['model'] ?? null,
                    'usage' => $draft['usage'] ?? [],
                    'clarification_count' => count($drafts[$provider]['clarifications'] ?? []),
                ];
            } catch (\Throwable $e) {
                $panel[$provider] = [
                    'status' => 'failed',
                    'error' => mb_substr($e->getMessage(), 0, 500),
                ];
            }
        }

        if (!$drafts) {
            throw new \RuntimeException('No CV-writing AI is configured. Add at least one server-side writer model/key before generating a candidate CV.');
        }

        $leadWriter = array_key_exists('openai', $drafts) ? 'openai' : (array_key_exists('anthropic', $drafts) ? 'anthropic' : 'gemini');
        $final = $drafts[$leadWriter];

        // With more than one independent draft, ask the lead writer to reconcile them
        // against the original source CV. This preserves facts while benefiting from
        // multiple viewpoints.
        if (count($drafts) > 1) {
            try {
                $synthesisContext = $context + [
                    'phase' => 'final_synthesis',
                    'instruction' => 'Reconcile independent drafts. Keep only facts supported by the source CV. Return one final polished CV content object.',
                ];
                $result = match ($leadWriter) {
                    'openai' => $this->callOpenAi($this->openAiConfig(), $cvText, $synthesisContext, $drafts),
                    'anthropic' => $this->callAnthropic($this->anthropicConfig(), $cvText, $synthesisContext, $drafts),
                    default => $this->callGemini($this->geminiConfig(), $cvText, $synthesisContext, $drafts),
                };
                $final = $this->normalise($result['content'] ?? []);
                $panel['synthesis'] = [
                    'status' => 'completed',
                    'provider' => $leadWriter,
                    'model' => $result['model'] ?? null,
                    'usage' => $result['usage'] ?? [],
                ];
            } catch (\Throwable $e) {
                $panel['synthesis'] = [
                    'status' => 'failed_fallback_to_lead_draft',
                    'provider' => $leadWriter,
                    'error' => mb_substr($e->getMessage(), 0, 500),
                ];
            }
        }

        if (empty($final['summary']) || empty($final['experience'])) {
            throw new \RuntimeException('Writer panel did not produce enough structured CV content for a professional draft.');
        }

        return ['content' => $final, 'panel' => $panel, 'lead_writer' => $leadWriter];
    }

    private function openAiConfig(): ?array
    {
        $key = trim((string) (getenv('OPENAI_API_KEY') ?: ''));
        $model = trim((string) (getenv('OPENAI_CV_WRITER_MODEL') ?: getenv('OPENAI_CV_MODEL') ?: ''));
        return ($key !== '' && $model !== '') ? ['key' => $key, 'model' => $model] : null;
    }

    private function anthropicConfig(): ?array
    {
        $key = trim((string) (getenv('ANTHROPIC_API_KEY') ?: ''));
        $model = trim((string) (getenv('ANTHROPIC_CV_WRITER_MODEL') ?: getenv('ANTHROPIC_CV_MODEL') ?: ''));
        return ($key !== '' && $model !== '') ? ['key' => $key, 'model' => $model] : null;
    }

    private function geminiConfig(): ?array
    {
        $key = trim((string) (getenv('GEMINI_API_KEY') ?: ''));
        $model = trim((string) (getenv('GEMINI_CV_WRITER_MODEL') ?: getenv('GEMINI_CV_MODEL') ?: ''));
        return ($key !== '' && $model !== '') ? ['key' => $key, 'model' => $model] : null;
    }

    private function callOpenAi(array $config, string $cvText, array $context, array $drafts = []): array
    {
        $client = service('curlrequest', ['timeout' => 60]);
        $response = $client->post('https://api.openai.com/v1/responses', [
            'headers' => [
                'Authorization' => 'Bearer ' . $config['key'],
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $config['model'],
                'instructions' => CvWriterPrompt::system('lead professional resume writer and recruiter'),
                'input' => CvWriterPrompt::user($cvText, $context, $drafts),
                'max_output_tokens' => 7000,
            ],
            'http_errors' => false,
            'timeout' => 60,
        ]);
        $status = $response->getStatusCode();
        $body = json_decode((string) $response->getBody(), true);
        if ($status < 200 || $status >= 300 || !is_array($body)) {
            throw new \RuntimeException('OpenAI CV writer failed with HTTP ' . $status . '.');
        }
        $text = (string) ($body['output_text'] ?? '');
        if ($text === '') {
            foreach (($body['output'] ?? []) as $item) {
                foreach (($item['content'] ?? []) as $part) {
                    if (($part['type'] ?? '') === 'output_text') {
                        $text .= (string) ($part['text'] ?? '');
                    }
                }
            }
        }
        if ($text === '') {
            throw new \RuntimeException('OpenAI CV writer returned no text.');
        }
        return [
            'content' => CvWriterPrompt::decodeJson($text),
            'model' => $body['model'] ?? $config['model'],
            'usage' => $body['usage'] ?? [],
        ];
    }

    private function callAnthropic(array $config, string $cvText, array $context, array $drafts = []): array
    {
        $client = service('curlrequest', ['timeout' => 60]);
        $response = $client->post('https://api.anthropic.com/v1/messages', [
            'headers' => [
                'x-api-key' => $config['key'],
                'anthropic-version' => '2023-06-01',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $config['model'],
                'max_tokens' => 7000,
                'system' => CvWriterPrompt::system('senior resume writer, leadership editor and skeptical recruiter'),
                'messages' => [[
                    'role' => 'user',
                    'content' => CvWriterPrompt::user($cvText, $context, $drafts),
                ]],
            ],
            'http_errors' => false,
            'timeout' => 60,
        ]);
        $status = $response->getStatusCode();
        $body = json_decode((string) $response->getBody(), true);
        if ($status < 200 || $status >= 300 || !is_array($body)) {
            throw new \RuntimeException('Anthropic CV writer failed with HTTP ' . $status . '.');
        }
        $text = '';
        foreach (($body['content'] ?? []) as $part) {
            if (($part['type'] ?? '') === 'text') {
                $text .= (string) ($part['text'] ?? '');
            }
        }
        if ($text === '') {
            throw new \RuntimeException('Anthropic CV writer returned no text.');
        }
        return [
            'content' => CvWriterPrompt::decodeJson($text),
            'model' => $body['model'] ?? $config['model'],
            'usage' => $body['usage'] ?? [],
        ];
    }

    private function callGemini(array $config, string $cvText, array $context, array $drafts = []): array
    {
        $client = service('curlrequest', ['timeout' => 60]);
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . rawurlencode($config['model']) . ':generateContent';
        $response = $client->post($url, [
            'headers' => [
                'x-goog-api-key' => $config['key'],
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'systemInstruction' => [
                    'parts' => [['text' => CvWriterPrompt::system('ATS resume architect, recruiter and evidence verifier')]],
                ],
                'contents' => [[
                    'role' => 'user',
                    'parts' => [['text' => CvWriterPrompt::user($cvText, $context, $drafts)]],
                ]],
                'generationConfig' => [
                    'temperature' => 0.15,
                    'maxOutputTokens' => 7000,
                    'responseMimeType' => 'application/json',
                ],
            ],
            'http_errors' => false,
            'timeout' => 60,
        ]);
        $status = $response->getStatusCode();
        $body = json_decode((string) $response->getBody(), true);
        if ($status < 200 || $status >= 300 || !is_array($body)) {
            throw new \RuntimeException('Gemini CV writer failed with HTTP ' . $status . '.');
        }
        $text = '';
        foreach (($body['candidates'][0]['content']['parts'] ?? []) as $part) {
            $text .= (string) ($part['text'] ?? '');
        }
        if ($text === '') {
            throw new \RuntimeException('Gemini CV writer returned no text.');
        }
        return [
            'content' => CvWriterPrompt::decodeJson($text),
            'model' => $body['modelVersion'] ?? $config['model'],
            'usage' => $body['usageMetadata'] ?? [],
        ];
    }

    private function normalise(array $data): array
    {
        $experience = [];
        foreach (($data['experience'] ?? []) as $item) {
            if (!is_array($item)) {
                continue;
            }
            $bullets = $this->strings($item['bullets'] ?? [], 8);
            if (trim((string) ($item['company'] ?? '')) === '' && trim((string) ($item['title'] ?? '')) === '') {
                continue;
            }
            $experience[] = [
                'company' => trim((string) ($item['company'] ?? '')),
                'title' => trim((string) ($item['title'] ?? '')),
                'location' => trim((string) ($item['location'] ?? '')),
                'dates' => trim((string) ($item['dates'] ?? '')),
                'bullets' => $bullets,
            ];
        }

        $clarifications = [];
        foreach (($data['clarifications'] ?? []) as $item) {
            if (!is_array($item) || trim((string) ($item['question'] ?? '')) === '') {
                continue;
            }
            $clarifications[] = [
                'field' => trim((string) ($item['field'] ?? '')),
                'question' => trim((string) ($item['question'] ?? '')),
                'why_needed' => trim((string) ($item['why_needed'] ?? '')),
            ];
        }

        return [
            'target_title' => trim((string) ($data['target_title'] ?? '')),
            'headline' => trim((string) ($data['headline'] ?? '')),
            'summary' => trim((string) ($data['summary'] ?? '')),
            'core_skills' => $this->strings($data['core_skills'] ?? [], 18),
            'experience' => array_slice($experience, 0, 12),
            'selected_achievements' => $this->strings($data['selected_achievements'] ?? [], 10),
            'education' => $this->strings($data['education'] ?? [], 8),
            'certifications' => $this->strings($data['certifications'] ?? [], 10),
            'tools' => $this->strings($data['tools'] ?? [], 15),
            'board_highlights' => $this->strings($data['board_highlights'] ?? [], 8),
            'clarifications' => array_slice($clarifications, 0, 12),
            'quality_notes' => $this->strings($data['quality_notes'] ?? [], 10),
        ];
    }

    private function strings($value, int $max): array
    {
        if (!is_array($value)) {
            return [];
        }
        $out = [];
        foreach ($value as $item) {
            if (!is_scalar($item)) {
                continue;
            }
            $item = trim((string) $item);
            if ($item !== '' && !in_array($item, $out, true)) {
                $out[] = $item;
            }
        }
        return array_slice($out, 0, $max);
    }
}
