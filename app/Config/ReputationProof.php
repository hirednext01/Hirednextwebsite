<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class ReputationProof extends BaseConfig
{
    public string $founderLinkedIn = 'https://in.linkedin.com/in/tarushikhaarora';
    public int $linkedInRecommendationCount = 12;

    /**
     * Public, externally verifiable reputation signals.
     *
     * Keep excerpts short and source-linked. These are not star ratings and
     * must not be represented as client outcome claims unless the source says so.
     */
    public array $items = [
        [
            'name' => 'Moiz Ali',
            'proof_type' => 'Recruitment Partnership',
            'source_label' => 'LinkedIn',
            'source_url' => 'https://www.linkedin.com/posts/mdmoizali_newbeginnings-entrepreneurship-grateful-activity-7275465561612894209-JxSz',
            'excerpt' => "I have immense respect for Taru's vision and leadership.",
            'context' => 'Public LinkedIn partnership announcement naming HiredNext and Taru Shikha in the context of recruitment and talent acquisition.',
            'sort_order' => -100,
        ],
        [
            'name' => 'Divya Kumar',
            'proof_type' => 'Recruitment Experience',
            'source_label' => 'LinkedIn Recommendation',
            'source_url' => 'https://in.linkedin.com/in/tarushikhaarora',
            'excerpt' => 'She brings a very human approach and takes the time to truly listen and understand.',
            'context' => 'Public LinkedIn recommendation highlighting Taru Shikha’s clarity, approachability, professionalism and empathy.',
            'sort_order' => -90,
        ],
        [
            'name' => 'Vivek Raj',
            'proof_type' => 'Candidate Experience',
            'source_label' => 'LinkedIn Recommendation',
            'source_url' => 'https://in.linkedin.com/in/tarushikhaarora',
            'excerpt' => 'Going above and beyond; her efforts bring clarity, happiness, and confidence.',
            'context' => 'Public LinkedIn recommendation describing the career impact of Taru Shikha’s HR and recruitment support.',
            'sort_order' => -80,
        ],
        [
            'name' => 'Dr. Anup Gopalakrishnan',
            'proof_type' => 'Recruitment Thought Leadership',
            'source_label' => 'LinkedIn',
            'source_url' => 'https://www.linkedin.com/posts/tarushikhaarora_grateful-to-be-featured-byet-edge-insights-activity-7406249166634598401-WONy',
            'excerpt' => 'AI-powered humans versus outdated processes.',
            'context' => 'Public LinkedIn comment endorsing Taru Shikha’s framing of AI and human judgement in recruitment.',
            'sort_order' => -70,
        ],
    ];
}
