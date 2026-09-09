<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class PublishKidswearSales extends BaseCommand
{
    protected $group = 'HiredNext';
    protected $name = 'jobs:publish-kidswear-sales';
    protected $description = 'Publish/update the HiredNext South India kidswear sales mandate.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('jobs')) {
            CLI::error('jobs table does not exist.');
            return;
        }

        $slug = 'sales-manager-kidswear-south-india';
        $now = date('Y-m-d H:i:s');

        $owner = $db->table('users')
            ->select('id')
            ->groupStart()
                ->where('email', 'tarushikha@hirednext.info')
                ->orWhere('username', 'taru')
            ->groupEnd()
            ->get()
            ->getRowArray();

        $description = <<<'HTML'
<p><strong>Job code: HN-KW-SALES-0909</strong></p>
<p>HiredNext is managing a mandate for an established <strong>Sri Lankan manufacturer and exporter of children’s wear</strong> looking to strengthen its presence in the Indian market.</p>
<p>The company is seeking a strong sales professional who can take ownership of <strong>South India</strong> and build business with organised retail chains and relevant retail partners.</p>

<h3>Territory & category</h3>
<ul>
<li><strong>Territory:</strong> Tamil Nadu, Karnataka and Kerala.</li>
<li><strong>Key market:</strong> Chennai plus major South India retail markets.</li>
<li><strong>Category:</strong> Children’s Wear / Kidswear.</li>
<li><strong>Company:</strong> Sri Lankan manufacturer and exporter.</li>
</ul>

<h3>What you will own</h3>
<ul>
<li>Develop the South India market for the company’s kidswear range.</li>
<li>Identify and open relationships with retail chains and key accounts.</li>
<li>Present products and collections to buyers and decision-makers.</li>
<li>Convert new accounts and expand distribution.</li>
<li>Manage commercial discussions and drive order closures.</li>
<li>Build strong, long-term relationships with retail partners.</li>
<li>Track market opportunities, competition and customer requirements.</li>
<li>Take ownership of sales growth across the territory.</li>
</ul>

<h3>Who should explore this?</h3>
<ul>
<li>Sales professionals with experience in <strong>kidswear, apparel, garments or related retail categories</strong>.</li>
<li>Strong relationships with retail chains or organised retailers in South India.</li>
<li>Someone who understands how to <strong>open accounts, sell product and grow them</strong>.</li>
<li>Comfortable travelling extensively across Tamil Nadu, Karnataka and Kerala.</li>
<li>Strong commercial and negotiation skills.</li>
<li>Independent, market-facing and comfortable owning a region.</li>
</ul>

<p>This could be particularly interesting for someone who already understands the South India retail ecosystem and wants to represent an international manufacturer while building a market substantially.</p>

<h3>Apply / explore this role</h3>
<p>Apply through the HiredNext form on this page or email your CV to <a href="mailto:jobs@hirednext.info?subject=HN-KW-SALES-0909%20%7C%20Sales%20Manager%20Kidswear%20South%20India">jobs@hirednext.info</a>.</p>
<p><strong>Want to assess your CV before applying?</strong> <a href="https://hirednext.net/cv-assessment">Use the HiredNext CV Assessment</a>.</p>
<p><strong>Follow Taru Shikha for new mandates and hiring insights:</strong> <a href="https://www.linkedin.com/in/tarushikhaarora/" rel="noopener noreferrer">LinkedIn</a>.</p>
<p>HiredNext does not charge candidates to apply for jobs or secure placement.</p>
HTML;

        $data = [
            'title' => 'Sales Manager – Kidswear | South India',
            'slug' => $slug,
            'location' => 'South India – Tamil Nadu, Karnataka & Kerala',
            'type' => 'full-time',
            'department' => 'Kidswear / Apparel Sales',
            'experience' => 'Relevant sales experience in kidswear, apparel or related retail categories',
            'description' => $description,
            'status' => 'open',
            'created_by' => $owner['id'] ?? null,
            'updated_at' => $now,
        ];

        $existing = $db->table('jobs')->select('id')->where('slug', $slug)->get()->getRowArray();
        if ($existing) {
            $db->table('jobs')->where('id', $existing['id'])->update($data);
            CLI::write('UPDATED: ' . $slug, 'green');
            CLI::write('URL: https://hirednext.net/jobs/' . $slug, 'cyan');
            return;
        }

        $data['created_at'] = $now;
        $db->table('jobs')->insert($data);
        CLI::write('PUBLISHED: ' . $slug, 'green');
        CLI::write('URL: https://hirednext.net/jobs/' . $slug, 'cyan');
    }
}
