<?php

namespace App\Services\Cv;

class CvTextExtractor
{
    public function extract(string $absolutePath): array
    {
        if (!is_file($absolutePath) || !is_readable($absolutePath)) {
            throw new \RuntimeException('CV file is missing or unreadable.');
        }

        $ext = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
        $meta = [
            'extension' => $ext,
            'bytes' => filesize($absolutePath) ?: 0,
            'method' => null,
        ];

        switch ($ext) {
            case 'docx':
                $text = $this->extractDocx($absolutePath);
                $meta['method'] = 'docx_xml';
                break;

            case 'pdf':
                $binary = $this->findBinary('pdftotext');
                if (!$binary) {
                    throw new \RuntimeException('PDF text extraction requires pdftotext on the server. The CV remains stored and can still be downloaded from admin.');
                }
                $text = $this->runCommand($binary, ['-layout', '-nopgbrk', $absolutePath, '-']);
                $meta['method'] = 'pdftotext';
                break;

            case 'doc':
                $binary = $this->findBinary('antiword') ?: $this->findBinary('catdoc');
                if (!$binary) {
                    throw new \RuntimeException('DOC text extraction requires antiword or catdoc on the server. The CV remains stored and can still be downloaded from admin.');
                }
                $text = $this->runCommand($binary, [$absolutePath]);
                $meta['method'] = basename($binary);
                break;

            case 'txt':
                $text = (string) file_get_contents($absolutePath);
                $meta['method'] = 'plain_text';
                break;

            default:
                throw new \RuntimeException('Unsupported CV file type: ' . $ext);
        }

        $text = $this->normalise($text);
        $meta['characters'] = mb_strlen($text);
        $meta['words'] = preg_match_all('/\b[\pL\pN][\pL\pN\-+.&\/]*\b/u', $text) ?: 0;

        if (mb_strlen($text) < 120) {
            throw new \RuntimeException('Too little readable text could be extracted from this CV. It may be scanned/image-based or use an unsupported encoding.');
        }

        return ['text' => $text, 'meta' => $meta];
    }

    private function extractDocx(string $path): string
    {
        if (!class_exists(\ZipArchive::class)) {
            throw new \RuntimeException('DOCX extraction requires the PHP ZipArchive extension.');
        }

        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            throw new \RuntimeException('Unable to open DOCX file.');
        }

        $parts = [];
        foreach (['word/document.xml', 'word/header1.xml', 'word/footer1.xml'] as $entry) {
            $xml = $zip->getFromName($entry);
            if ($xml === false) {
                continue;
            }
            $xml = preg_replace('/<w:tab[^>]*\/>/i', "\t", $xml) ?? $xml;
            $xml = preg_replace('/<w:br[^>]*\/>/i', "\n", $xml) ?? $xml;
            $xml = preg_replace('/<\/w:p>/i', "\n", $xml) ?? $xml;
            $parts[] = html_entity_decode(strip_tags($xml), ENT_QUOTES | ENT_XML1, 'UTF-8');
        }
        $zip->close();

        return implode("\n", $parts);
    }

    private function normalise(string $text): string
    {
        $text = str_replace(["\r\n", "\r", "\xC2\xA0"], ["\n", "\n", ' '], $text);
        $text = preg_replace('/[ \t]+/u', ' ', $text) ?? $text;
        $text = preg_replace('/\n[ \t]+/u', "\n", $text) ?? $text;
        $text = preg_replace('/\n{3,}/u', "\n\n", $text) ?? $text;
        return trim($text);
    }

    private function findBinary(string $name): ?string
    {
        foreach (["/usr/bin/{$name}", "/usr/local/bin/{$name}", "/bin/{$name}"] as $path) {
            if (is_executable($path)) {
                return $path;
            }
        }

        if (function_exists('shell_exec')) {
            $found = trim((string) @shell_exec('command -v ' . escapeshellarg($name) . ' 2>/dev/null'));
            if ($found !== '' && is_executable($found)) {
                return $found;
            }
        }

        return null;
    }

    private function runCommand(string $binary, array $args): string
    {
        if (!function_exists('proc_open')) {
            throw new \RuntimeException('Server command execution is unavailable for CV extraction.');
        }

        $command = escapeshellarg($binary);
        foreach ($args as $arg) {
            $command .= ' ' . escapeshellarg((string) $arg);
        }

        $pipes = [];
        $process = @proc_open($command, [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ], $pipes);

        if (!is_resource($process)) {
            throw new \RuntimeException('Unable to start CV extraction process.');
        }

        fclose($pipes[0]);
        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exit = proc_close($process);

        if ($exit !== 0) {
            throw new \RuntimeException('CV extraction failed: ' . trim((string) $stderr));
        }

        return (string) $stdout;
    }
}
