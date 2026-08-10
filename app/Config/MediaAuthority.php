<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MediaAuthority extends BaseConfig
{
    public string $founderName = 'Taru Shikha';
    public string $founderLinkedIn = 'https://www.linkedin.com/in/tarushikhaarora';
    public string $companyLinkedIn = 'https://www.linkedin.com/company/hirednext-recruitment-service/';

    public array $coverage = [
        [
            'outlet' => 'India Today',
            'headline' => 'India is not promising jobs under new labour codes. It is promising re-skilling',
            'url' => 'https://www.indiatoday.in/education-today/jobs-and-careers/story/indias-new-worker-re-skilling-fund-changes-what-job-loss-really-means-2836254-2025-12-15',
            'published_at' => '2025-12-15',
            'coverage_type' => 'Industry story',
            'topic' => 'Labour reform and reskilling',
        ],
        [
            'outlet' => 'CNBC-TV18',
            'headline' => 'How structured staffing models shape financial outcomes for workers',
            'url' => 'https://www.cnbctv18.com/education/how-structured-staffing-models-shape-financial-outcomes-for-workers-19772106.htm',
            'published_at' => null,
            'coverage_type' => 'Industry story',
            'topic' => 'Structured staffing and workforce outcomes',
        ],
        [
            'outlet' => 'Outlook Money',
            'headline' => 'New Labour Laws May Cut Take-Home Pay: How Employees Can Protect Their Salary?',
            'url' => 'https://www.outlookmoney.com/retirement/news/new-labour-laws-may-cut-take-home-pay-how-employees-can-protect-their-salary',
            'published_at' => '2025-11-27',
            'coverage_type' => 'Industry story',
            'topic' => 'Labour codes and employee compensation',
        ],
        [
            'outlet' => 'News18',
            'headline' => 'Retirement Corpus To Get Bigger As New Labour Rules Push Up Worker Contributions',
            'url' => 'https://www.news18.com/business/retirement-cushion-to-get-bigger-as-new-rules-push-up-worker-contributions-ws-l-9729411.html',
            'published_at' => '2025-11-25',
            'coverage_type' => 'Industry story',
            'topic' => 'Labour codes and retirement benefits',
        ],
        [
            'outlet' => 'ET Edge Insights',
            'headline' => 'Manual vs AI recruitment: When tech wins and when humans must lead',
            'url' => 'https://etedge-insights.com/industry/hr/manual-vs-ai-recruitment-when-tech-wins-and-when-humans-must-lead/',
            'published_at' => '2025-12-10',
            'coverage_type' => 'Industry story',
            'topic' => 'AI and human judgement in recruitment',
        ],
        [
            'outlet' => 'The Hans India',
            'headline' => 'The Power Combo: How AI and Traditional Recruiters Together Create a Stronger Hiring Process',
            'url' => 'https://www.thehansindia.com/business/the-power-combo-how-ai-and-traditional-recruiters-together-create-a-stronger-hiring-process-1029847',
            'published_at' => '2025-12-09',
            'coverage_type' => 'Industry story',
            'topic' => 'AI-assisted recruitment',
        ],
        [
            'outlet' => 'ET Now Swadesh',
            'headline' => 'Consumer Is King: Delhi-NCR pollution and its impact on life and career decisions',
            'url' => 'https://www.youtube.com/watch?v=IkFNd1dTYRQ',
            'published_at' => null,
            'coverage_type' => 'Electronic',
            'topic' => 'Work, careers and Delhi-NCR pollution',
        ],
        [
            'outlet' => 'News18',
            'headline' => 'Is Your Boss Always Busy? Decoding The Rise Of Megamanager And Why Workers Are Feeling Pressured',
            'url' => 'https://www.news18.com/explainers/is-your-boss-always-busy-decoding-the-rise-of-megamanager-and-why-workers-are-feeling-pressured-shil-ws-l-9836247.html',
            'published_at' => '2026-01-16',
            'coverage_type' => 'Standalone story',
            'topic' => 'Management layers and workplace pressure',
        ],
        [
            'outlet' => 'ET Edge Insights',
            'headline' => 'India’s recruiters explore new approaches as skills and AI shape hiring decisions',
            'url' => 'https://etedge-insights.com/industry/hr/indias-recruiters-explore-new-approaches-as-skills-and-ai-shape-hiring-decisions/',
            'published_at' => '2026-01-09',
            'coverage_type' => 'Feature story',
            'topic' => 'Skills-first hiring and AI',
        ],
        [
            'outlet' => 'The Financial Express',
            'headline' => 'The fall of the campus hiring and the rise of always-on recruitment',
            'url' => 'https://www.financialexpress.com/jobs-career/the-fall-of-the-campus-hiring-and-the-rise-of-always-on-recruitment-4113576/',
            'published_at' => null,
            'coverage_type' => 'Industry story',
            'topic' => 'Skills-first and always-on recruitment',
        ],
    ];
}
