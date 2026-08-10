<?php

namespace App\Libraries;

class BlogSearchOptimizer
{
    private const SITE = 'https://hirednext.net';

    public function optimise(array $post, bool $enrichContent = true): array
    {
        $title = $this->cleanText($post['title'] ?? 'HiredNext insight');
        $content = html_entity_decode((string)($post['content'] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $plain = $this->cleanText($content);
        $category = $this->cleanText($post['category'] ?? 'Recruitment') ?: 'Recruitment';
        $excerpt = $this->cleanText($post['excerpt'] ?? '');

        if (mb_strlen($excerpt) < 90) {
            $excerpt = $this->truncate($plain, 165);
        } elseif (mb_strlen($excerpt) > 180) {
            $excerpt = $this->truncate($excerpt, 165);
        }

        $metaTitle = $this->cleanText($post['meta_title'] ?? '');
        if ($metaTitle === '' || mb_strlen($metaTitle) < 32 || mb_strlen($metaTitle) > 68) {
            $metaTitle = $this->buildMetaTitle($title);
        } elseif (stripos($metaTitle, 'HiredNext') === false) {
            $metaTitle = $this->truncate($metaTitle, 52) . ' | HiredNext';
        }

        $metaDescription = $this->cleanText($post['meta_description'] ?? '');
        if ($metaDescription === '' || mb_strlen($metaDescription) < 110 || mb_strlen($metaDescription) > 180) {
            $metaDescription = $this->buildMetaDescription($excerpt ?: $plain, $title);
        }

        $author = $this->cleanText($post['author_name'] ?? '') ?: 'HiredNext Editorial';
        if (strcasecmp($author, 'Metron Team') === 0) {
            $author = 'HiredNext Editorial';
        }

        $tags = $this->mergeTags((string)($post['tags'] ?? ''), $title . ' ' . $category . ' ' . $plain);
        $keywords = $this->cleanText($post['meta_keywords'] ?? '');
        if ($keywords === '' || substr_count($keywords, ',') < 2) {
            $keywords = implode(', ', $tags);
        }

        if ($enrichContent) {
            $content = $this->enrichContent($content, $title . ' ' . $category . ' ' . $plain);
        }

        return [
            'content' => $content,
            'excerpt' => $excerpt,
            'tags' => implode(', ', $tags),
            'author_name' => $author,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $keywords,
        ];
    }

    private function buildMetaTitle(string $title): string
    {
        $base = preg_replace('/\s*\|\s*HiredNext\s*$/i', '', $title);
        $base = $this->truncate((string)$base, 52);
        return rtrim($base, ' -|:') . ' | HiredNext';
    }

    private function buildMetaDescription(string $source, string $title): string
    {
        $text = $this->cleanText($source);
        if ($text === '') {
            $text = 'Recruiter-led insight from HiredNext on ' . strtolower($title) . ', with practical context for employers and professionals in India.';
        }
        return $this->truncate($text, 165);
    }

    private function mergeTags(string $existing, string $corpus): array
    {
        $tags = array_values(array_filter(array_map('trim', explode(',', $existing))));
        $map = [
            'AI Recruitment' => [' ai ', 'artificial intelligence', 'automation', 'machine learning'],
            'Executive Search' => ['executive search', 'cxo', 'chief executive', 'leadership hiring'],
            'Leadership Hiring' => ['leadership', 'senior hiring', 'functional head'],
            'Skills-First Hiring' => ['skills-first', 'skills first', 'skill-based', 'skill based'],
            'Candidate Experience' => ['candidate experience', 'candidate journey', 'ghosting', 'interview process'],
            'Career Strategy' => ['career', 'resume', 'cv ', 'interview', 'job search'],
            'BFSI' => ['bfsi', 'nbfc', 'banking', 'fintech', 'insurance'],
            'Retail' => ['retail', 'omnichannel', 'd2c', 'category management'],
            'Manufacturing' => ['manufacturing', 'plant', 'factory', 'operations leadership'],
            'Engineering' => ['engineering', 'technical leadership', 'projects', 'maintenance'],
            'Garment & Textile' => ['garment', 'textile', 'apparel', 'fashion'],
            'GCC Hiring' => ['gcc', 'global capability centre', 'global capability center'],
            'Recruitment India' => ['india', 'indian hiring', 'indian recruitment'],
            'Workforce Strategy' => ['workforce', 'staffing', 'labour', 'labor', 'reskilling', 'reskilling'],
        ];

        $haystack = ' ' . mb_strtolower($corpus) . ' ';
        foreach ($map as $tag => $needles) {
            foreach ($needles as $needle) {
                if (mb_strpos($haystack, mb_strtolower($needle)) !== false) {
                    $tags[] = $tag;
                    break;
                }
            }
        }

        $tags[] = 'HiredNext';
        $tags = array_values(array_unique(array_filter(array_map('trim', $tags))));
        return array_slice($tags, 0, 10);
    }

    private function enrichContent(string $html, string $corpus): string
    {
        if ($html === '' || stripos($html, 'data-hirednext-search-enrichment="1"') !== false) {
            return $html;
        }

        $plain = $this->cleanText($html);
        if (str_word_count($plain) < 180) {
            return $html;
        }

        $links = $this->relatedInternalLinks($corpus);
        $media = $this->relatedMedia($corpus);

        if (empty($links) && empty($media)) {
            return $html;
        }

        $append = '<section data-hirednext-search-enrichment="1">';

        if (!empty($links)) {
            $append .= '<h2>Related HiredNext resources</h2><ul>';
            foreach ($links as $link) {
                $append .= '<li><a href="' . htmlspecialchars($link['url'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8') . '</a></li>';
            }
            $append .= '</ul>';
        }

        if (!empty($media)) {
            $append .= '<h2>Related HiredNext commentary in the media</h2><ul>';
            foreach ($media as $item) {
                $label = $item['outlet'] . ': ' . $item['headline'];
                $append .= '<li><a href="' . htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') . '" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</a></li>';
            }
            $append .= '</ul>';
        }

        $append .= '</section>';
        return rtrim($html) . "\n" . $append;
    }

    private function relatedInternalLinks(string $corpus): array
    {
        $haystack = mb_strtolower($corpus);
        $links = [];

        $rules = [
            ['needles' => ['executive search', 'cxo', 'leadership hiring', 'senior leader'], 'label' => 'Executive Search & Leadership Hiring', 'url' => self::SITE . '/services/executive-search'],
            ['needles' => ['permanent hiring', 'mid-senior', 'specialist hiring'], 'label' => 'Permanent Hiring', 'url' => self::SITE . '/services/permanent-hiring'],
            ['needles' => ['resume', 'cv ', 'candidate', 'interview', 'career'], 'label' => 'Career Services for Candidates', 'url' => self::SITE . '/services/candidates'],
            ['needles' => ['ai ', 'artificial intelligence', 'automation', 'human judgement', 'human judgment'], 'label' => 'How HiredNext Uses AI in Recruitment', 'url' => self::SITE . '/about'],
            ['needles' => ['retail', 'omnichannel', 'd2c'], 'label' => 'Retail Executive Search', 'url' => self::SITE . '/industry/retail-executive-search'],
            ['needles' => ['bfsi', 'nbfc', 'banking', 'fintech', 'insurance'], 'label' => 'BFSI Leadership Hiring', 'url' => self::SITE . '/industry/bfsi-leadership-hiring'],
            ['needles' => ['manufacturing', 'plant leadership', 'factory'], 'label' => 'Manufacturing Talent Advisory', 'url' => self::SITE . '/industry/manufacturing-talent-advisory'],
            ['needles' => ['engineering', 'technical leadership', 'maintenance'], 'label' => 'Engineering Recruitment', 'url' => self::SITE . '/industry/engineering-recruitment-firm'],
            ['needles' => ['software', 'technology hiring', 'product leader', 'engineering leader', 'it recruitment'], 'label' => 'IT Recruitment Services India', 'url' => self::SITE . '/industry/it-recruitment-services-india'],
        ];

        foreach ($rules as $rule) {
            foreach ($rule['needles'] as $needle) {
                if (mb_strpos($haystack, $needle) !== false) {
                    $links[] = ['label' => $rule['label'], 'url' => $rule['url']];
                    break;
                }
            }
            if (count($links) >= 4) {
                break;
            }
        }

        $links[] = ['label' => 'Taru Shikha — Founder, HiredNext', 'url' => self::SITE . '/founder/taru-shikha'];
        return array_slice(array_values(array_unique($links, SORT_REGULAR)), 0, 4);
    }

    private function relatedMedia(string $corpus): array
    {
        $haystack = mb_strtolower($corpus);
        $triggerWords = ['ai ', 'artificial intelligence', 'skills-first', 'skills first', 'campus hiring', 'staffing', 'labour', 'labor', 'reskilling', 'salary', 'retirement', 'manager', 'management', 'workplace', 'career', 'pollution'];
        $triggered = false;
        foreach ($triggerWords as $trigger) {
            if (mb_strpos($haystack, $trigger) !== false) {
                $triggered = true;
                break;
            }
        }
        if (!$triggered) {
            return [];
        }

        $config = config('MediaAuthority');
        if (!$config || empty($config->coverage) || !is_array($config->coverage)) {
            return [];
        }

        $scored = [];
        foreach ($config->coverage as $item) {
            $topicText = mb_strtolower(($item['topic'] ?? '') . ' ' . ($item['headline'] ?? ''));
            $score = 0;
            foreach (['ai', 'skills', 'campus', 'staffing', 'labour', 'labor', 'reskill', 'salary', 'retirement', 'manager', 'workplace', 'career', 'pollution'] as $token) {
                if (mb_strpos($haystack, $token) !== false && mb_strpos($topicText, $token) !== false) {
                    $score++;
                }
            }
            if ($score > 0 && !empty($item['url'])) {
                $item['_score'] = $score;
                $scored[] = $item;
            }
        }

        usort($scored, static fn($a, $b) => ($b['_score'] ?? 0) <=> ($a['_score'] ?? 0));
        return array_slice($scored, 0, 2);
    }

    private function cleanText($value): string
    {
        $text = html_entity_decode(strip_tags((string)$value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return trim((string)preg_replace('/\s+/u', ' ', $text));
    }

    private function truncate(string $value, int $limit): string
    {
        $text = $this->cleanText($value);
        if (mb_strlen($text) <= $limit) {
            return $text;
        }
        $cut = mb_substr($text, 0, $limit + 1);
        $space = mb_strrpos($cut, ' ');
        if ($space !== false) {
            $cut = mb_substr($cut, 0, $space);
        }
        return rtrim($cut, " \t\n\r\0\x0B,.;:-") . '…';
    }
}
