<?php

namespace App\Commands;

use App\Libraries\BlogSearchOptimizer;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class PublishSeniorShortlistBlog extends BaseCommand
{
    protected $group = 'SEO';
    protected $name = 'blog:publish-senior-shortlist';
    protected $description = 'Publish the HiredNext authority article on why senior hiring fails after the shortlist.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        if (!$db->tableExists('blog_posts')) {
            CLI::error('blog_posts table not found. No changes made.');
            return;
        }

        $slug = 'why-senior-hiring-fails-after-shortlist-india';
        $title = 'Why Senior Hiring Fails After the Shortlist: 8 Preventable Breakpoints';

        $existing = $db->table('blog_posts')
            ->select('id, title, slug')
            ->where('slug', $slug)
            ->get()
            ->getRowArray();

        if ($existing) {
            CLI::write('Article already exists: ' . $existing['title'], 'yellow');
            return;
        }

        $content = <<<'HTML'
<p><strong>A strong shortlist does not guarantee a successful senior hire.</strong> In leadership and specialist recruitment, some of the most expensive failures happen after relevant candidates have already been identified. The search appears to be working, but momentum is lost during assessment, alignment, offer or joining.</p>

<p>The practical question for employers is not only <em>“Can we find the right people?”</em> It is also <strong>“Can our hiring process convert the right people once we find them?”</strong></p>

<h2>1. The decision-makers were never fully aligned</h2>
<p>Senior searches often involve founders, business heads, HR leaders, functional stakeholders, boards or investors. If those stakeholders are using different definitions of the ideal candidate, the shortlist becomes a moving target.</p>
<p>Before interviews begin, agree the business outcomes, non-negotiables, acceptable trade-offs and who has final decision authority. A recruiter can map the market accurately only when the organisation itself is calibrated.</p>

<h2>2. The role changes after candidates enter the process</h2>
<p>Scope can evolve during a search, but unspoken changes create avoidable failure. A role that starts as transformation may become steady-state execution. A mandate sold as strategic may become operational. Reporting lines, location expectations or compensation may shift.</p>
<p>When the brief changes, recalibrate it explicitly with candidates and the search team rather than continuing as if nothing changed.</p>

<h2>3. Interviews test opinions instead of evidence</h2>
<p>Senior candidates are easy to over-assess on presentation style, employer brand or title. The stronger approach is to test evidence: what the candidate personally owned, what changed under their leadership, what scale they handled, what constraints existed and what results can reasonably be attributed to them.</p>
<p>For leadership hiring, similar titles can hide very different levels of complexity and decision authority.</p>

<h2>4. Too many interview stages dilute conviction</h2>
<p>Adding interviewers does not automatically improve judgement. Repeated stages can create contradictory feedback, candidate fatigue and delay without generating new information.</p>
<p>Each stage should answer a distinct question. If two interviewers are assessing the same thing in the same way, the process may be longer without becoming better.</p>

<h2>5. Candidate motivation is tested too late</h2>
<p>A candidate can be highly qualified and still be unlikely to move. Motivation should be understood before the final stage: career direction, compensation, location, family constraints, notice period, counteroffer risk and what the candidate would be giving up by changing roles.</p>
<p>Late discovery of these issues is one of the easiest ways to waste weeks of senior stakeholder time.</p>

<h2>6. Compensation is treated as a closing issue instead of a search input</h2>
<p>Compensation is part of market calibration. If the approved range consistently sits below credible candidates at the required level, that is useful information about the mandate.</p>
<p>The response may be to change scope, seniority, location flexibility, variable pay or the target talent pool. Repeating the same search without adjusting the constraint rarely fixes the underlying problem.</p>

<h2>7. Decision speed collapses after a good interview</h2>
<p>Scarce candidates often have multiple conversations running at the same time. A long silence after a positive interview communicates uncertainty even when the employer remains interested.</p>
<p>Fast hiring does not mean careless hiring. It means clear decision rights, scheduled feedback and fewer avoidable gaps between stages.</p>

<h2>8. The employer stops recruiting after the offer is accepted</h2>
<p>For senior hires, acceptance is not the finish line. Counteroffers, retention efforts, notice-period fatigue and second thoughts can all appear before joining.</p>
<p>Maintain structured contact through resignation and notice period. Keep reinforcing the role, business context and reasons for the move without turning the relationship into pressure.</p>

<h2>The shortlist is only one part of the hiring system</h2>
<p>A recruiter can identify strong candidates, but conversion depends on the full process around them: role clarity, stakeholder alignment, evidence-led assessment, compensation realism, communication and decision speed.</p>

<p>For difficult or leadership hiring, employers should review the process before concluding that the market has no candidates.</p>

<h2>A practical pre-interview check</h2>
<ul>
<li>Are all decision-makers aligned on the first-year outcomes?</li>
<li>Is the compensation range genuinely approved?</li>
<li>Does every interview stage have a distinct purpose?</li>
<li>Who owns candidate communication between stages?</li>
<li>How quickly will feedback be given?</li>
<li>What trade-offs are acceptable if the perfect profile does not exist?</li>
</ul>

<p>Read HiredNext’s <a href="https://hirednext.net/blog/how-to-hire-cxo-india-executive-search">guide to hiring a CXO in India</a>, compare <a href="https://hirednext.net/blog/executive-search-vs-recruitment-agency-india">executive search vs regular recruitment</a>, or explore our <a href="https://hirednext.net/services/executive-search">executive search and leadership hiring</a> approach.</p>

<p><strong>Planning a critical hire?</strong> HiredNext works on executive, leadership, mid-senior and specialist mandates where market mapping, evidence and candidate conversion matter.</p>
HTML;

        $base = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'excerpt' => 'A strong shortlist can still fail. Eight preventable breakdowns in senior hiring often happen after relevant candidates have already been identified.',
            'featured_image' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&q=82&w=1400',
            'category' => 'Leadership Hiring',
            'tags' => 'Senior Hiring India, Leadership Hiring, Executive Search, Candidate Conversion, Hiring Process, HiredNext',
            'author_name' => 'Taru Shikha',
            'meta_title' => 'Why Senior Hiring Fails After the Shortlist | HiredNext',
            'meta_description' => 'Eight preventable reasons senior hiring fails after a strong shortlist: stakeholder misalignment, slow decisions, weak evidence, compensation gaps and offer-stage risk.',
            'meta_keywords' => 'Senior Hiring India, Leadership Hiring, Executive Search India, Candidate Drop Off, Hiring Process, HiredNext',
        ];

        $optimizer = new BlogSearchOptimizer();
        $optimized = $optimizer->optimise($base, true);
        $now = date('Y-m-d H:i:s');
        $payload = array_merge($base, $optimized, [
            'status' => 'published',
            'sort_order' => 0,
            'published_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        if (!$db->table('blog_posts')->insert($payload)) {
            CLI::error('Failed to publish article.');
            return;
        }

        CLI::write('Published: ' . $title, 'green');
        $this->notifyIndexNow(base_url('blog/' . $slug));
    }

    private function notifyIndexNow(string $url): void
    {
        try {
            $config = config('SearchDiscovery');
            if (!$config || empty($config->indexNowKey) || empty($config->indexNowEndpoint)) {
                return;
            }

            $host = parse_url(base_url(), PHP_URL_HOST);
            if (!$host) {
                return;
            }

            $client = \Config\Services::curlrequest([
                'timeout' => 3,
                'connect_timeout' => 2,
                'http_errors' => false,
            ]);

            $client->post($config->indexNowEndpoint, [
                'json' => [
                    'host' => $host,
                    'key' => $config->indexNowKey,
                    'keyLocation' => rtrim(base_url(), '/') . '/' . $config->indexNowKey . '.txt',
                    'urlList' => [$url],
                ],
            ]);
        } catch (\Throwable $e) {
            // Search discovery notification must never block publishing.
        }
    }
}
