<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class ReputationProof extends BaseConfig
{
    public string $founderLinkedIn = 'https://in.linkedin.com/in/tarushikhaarora';
    public int $linkedInRecommendationCount = 13;

    /**
     * Source-linked external reputation signals for HiredNext and Taru Shikha.
     *
     * Excerpts are intentionally short. LinkedIn recommendations do not carry
     * star ratings and must not be represented as rated reviews. Some LinkedIn
     * recommendation text may require an authenticated LinkedIn session to view.
     */
    public array $items = [
        [
            'name' => 'Manoj Dimri',
            'designation' => 'CEO, Stellar Manufacturing',
            'proof_type' => 'Employer Recruitment Experience',
            'source_label' => 'LinkedIn Recommendation',
            'source_url' => 'https://in.linkedin.com/in/tarushikhaarora',
            'excerpt' => 'HiredNext is an efficient and reliable recruitment agency. Their deep industry knowledge, personalised approach, and commitment to quality hires set them apart.',
            'context' => 'Employer-side recommendation from a senior manufacturing leader highlighting recruitment quality, industry knowledge and fit.',
            'sort_order' => -130,
        ],
        [
            'name' => 'JP Mohanty',
            'designation' => 'Senior Director, Marriott International',
            'proof_type' => 'Employer Recruitment Delivery',
            'source_label' => 'LinkedIn Recommendation',
            'source_url' => 'https://in.linkedin.com/in/tarushikhaarora',
            'excerpt' => 'We were highly impressed with her ability to meet our needs and the quality of her candidates overall.',
            'context' => 'Employer-side recommendation from a senior revenue-strategy leader describing responsiveness, candidate quality, hit rate and turnaround time.',
            'sort_order' => -125,
        ],
        [
            'name' => 'Bharat Ahuja',
            'designation' => 'Apparel, Textiles & Sustainability Leader',
            'proof_type' => 'Apparel & Textile Recruitment',
            'source_label' => 'LinkedIn Recommendation',
            'source_url' => 'https://in.linkedin.com/in/tarushikhaarora',
            'excerpt' => 'Her commitment and sense of integrity to both, the organization as well as the candidate, is praiseworthy.',
            'context' => 'Client recommendation from an apparel, textiles and sustainability leader highlighting depth of candidate understanding and integrity.',
            'sort_order' => -120,
        ],
        [
            'name' => 'Suraj Gautam',
            'designation' => 'Merchandising & Sourcing Leader',
            'proof_type' => 'Apparel Recruitment Expertise',
            'source_label' => 'LinkedIn Recommendation',
            'source_url' => 'https://in.linkedin.com/in/tarushikhaarora',
            'excerpt' => 'Her extensive knowledge of this industry coupled with the in-depth understanding of the client makes her a reliable partner.',
            'context' => 'Industry recommendation from a merchandising and sourcing leader highlighting apparel-industry knowledge, network and client understanding.',
            'sort_order' => -115,
        ],
        [
            'name' => 'RAJAN WIGG',
            'designation' => 'Country Head, Mirza Bangla',
            'proof_type' => 'Recruitment Partnership',
            'source_label' => 'LinkedIn Recommendation',
            'source_url' => 'https://in.linkedin.com/in/tarushikhaarora',
            'excerpt' => 'Hirednext is an extremely focused, result oriented and professional organization and they have an indepth knowledge of their area of work.',
            'context' => 'Senior industry recommendation highlighting HiredNext professionalism, focus, domain knowledge and Taru Shikha’s integrity.',
            'sort_order' => -110,
        ],
        [
            'name' => 'Pinky Kotecha',
            'designation' => 'Founder, Meeraki Bizz',
            'proof_type' => 'Talent Evaluation',
            'source_label' => 'LinkedIn Recommendation',
            'source_url' => 'https://in.linkedin.com/in/tarushikhaarora',
            'excerpt' => 'Her expert evaluation before presenting a suitable candidate makes hirer’s life easier to identify suitable talent for a organisation.',
            'context' => 'Client recommendation highlighting understanding of talent needs and candidate evaluation before presentation.',
            'sort_order' => -105,
        ],
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
            'designation' => 'Senior HR Business Partner',
            'proof_type' => 'Recruitment Experience',
            'source_label' => 'LinkedIn Recommendation',
            'source_url' => 'https://in.linkedin.com/in/tarushikhaarora',
            'excerpt' => 'She brings a very human approach and takes the time to truly listen and understand.',
            'context' => 'Client recommendation highlighting Taru Shikha’s clarity, approachability, professionalism and empathy.',
            'sort_order' => -90,
        ],
        [
            'name' => 'Vivek Raj',
            'designation' => 'Senior Consultant, Capgemini',
            'proof_type' => 'Candidate Experience',
            'source_label' => 'LinkedIn Recommendation',
            'source_url' => 'https://in.linkedin.com/in/tarushikhaarora',
            'excerpt' => 'Going above and beyond; her efforts bring clarity, happiness, and confidence.',
            'context' => 'LinkedIn recommendation describing the career impact of Taru Shikha’s HR and recruitment support.',
            'sort_order' => -80,
        ],
        [
            'name' => 'Sujeet Kumar',
            'proof_type' => 'Career & Recruitment Support',
            'source_label' => 'LinkedIn Recommendation',
            'source_url' => 'https://in.linkedin.com/in/tarushikhaarora',
            'excerpt' => 'Taru is an exceptional Job Consultant with a proven track record of helping individuals find meaningful employment.',
            'context' => 'Client recommendation highlighting personalised guidance, job-market knowledge and career support.',
            'sort_order' => -75,
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
