<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PublishBuyingMerchandisingMumbai extends Migration
{
    private const SLUG = 'buying-merchandising-fashion-retail-mumbai';

    public function up()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jobs');

        $creator = $db->table('users')
            ->select('id')
            ->where('email', 'tarushikha@hirednext.info')
            ->get()
            ->getRowArray();

        if (!$creator) {
            $creator = $db->table('users')
                ->select('id')
                ->where('role', 'admin')
                ->orderBy('id', 'ASC')
                ->get()
                ->getRowArray();
        }

        if (!$creator) {
            throw new \RuntimeException('Cannot publish Buying & Merchandising role: no admin user is available for created_by.');
        }

        $posterUrl = base_url('theme/assets/jobs/buying-merchandising-mumbai.svg');
        $description = '<div class="mb-8"><img src="' . esc($posterUrl) . '" alt="HiredNext Buying and Merchandising opening in Mumbai, CTC up to 30 LPA" style="width:100%;max-width:760px;height:auto;border-radius:18px;display:block;margin:0 auto;" loading="eager"></div>'
            . '<p><strong>Job code: HN-BM-0909</strong></p>'
            . '<p>HiredNext is managing a search for an experienced <strong>Buying &amp; Merchandising professional</strong> for a leading fashion retail business in Mumbai.</p>'
            . '<p>This is a commercially driven role for someone who understands not just product, but the complete business of buying — <strong>range, pricing, OTB, inventory, sell-through, partners and profitability</strong>.</p>'
            . '<h3>What will you own?</h3><ul>'
            . '<li>Seasonal buying strategy and range planning.</li>'
            . '<li>Range width, depth and price architecture.</li>'
            . '<li>Open-to-Buy (OTB) planning and management.</li>'
            . '<li>Sales forecasting and demand planning.</li>'
            . '<li>Sell-through, inventory turns and stock-to-sales performance.</li>'
            . '<li>Range selection, pricing and intake phasing.</li>'
            . '<li>Partner management and commercial negotiations.</li>'
            . '<li>Vendor strategy, sourcing and cost negotiations.</li>'
            . '<li>Seasonal assortment and trading reviews.</li>'
            . '<li>Cross-functional coordination with Marketing, VM, Sales and Finance.</li>'
            . '</ul>'
            . '<h3>Candidate profile</h3><ul>'
            . '<li><strong>10+ years</strong> in Buying and/or Merchandising within fashion retail or a branded environment.</li>'
            . '<li>Strong understanding of <strong>women’s western wear</strong> — product, trends, fabrics and construction.</li>'
            . '<li>Strong commercial and negotiation capability.</li>'
            . '<li>Hands-on experience with <strong>OTB, range planning and sales forecasting</strong>.</li>'
            . '<li>Strong analytical orientation and advanced Excel capability.</li>'
            . '<li>Experience working across multiple channels/partners is valuable.</li>'
            . '<li>Comfortable engaging senior stakeholders and external business partners.</li>'
            . '<li>High ownership and ability to independently drive commercial outcomes.</li>'
            . '</ul>'
            . '<h3>Location, compensation &amp; reporting</h3>'
            . '<p><strong>Mumbai | CTC up to ₹30 LPA | Reporting to B&amp;M Head</strong></p>'
            . '<p>If your experience sits at the intersection of <strong>product + numbers + consumer understanding + commercial decision-making</strong>, HiredNext would like to hear from you.</p>'
            . '<h3>How to apply</h3>'
            . '<p>Apply through the form on this page. Every application is routed to <a href="mailto:jobs@hirednext.info?subject=HN-BM-0909%20%7C%20Buying%20%26%20Merchandising">jobs@hirednext.info</a>. You may also email your CV directly with the subject <strong>HN-BM-0909 | Buying &amp; Merchandising</strong>.</p>'
            . '<p>Want to assess your CV before applying? <a href="' . base_url('cv-assessment') . '">Use the HiredNext CV Assessment</a>.</p>'
            . '<p>HiredNext does not charge candidates to apply for a role or secure placement.</p>';

        $data = [
            'title' => 'Buying & Merchandising – Fashion Retail',
            'slug' => self::SLUG,
            'location' => 'Mumbai',
            'type' => 'full-time',
            'description' => $description,
            'department' => 'Retail / Buying & Merchandising',
            'experience' => '10+ years',
            'status' => 'open',
            'created_by' => (int) $creator['id'],
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $existing = $builder->where('slug', self::SLUG)->get()->getRowArray();
        if ($existing) {
            $builder->where('id', $existing['id'])->update($data);
            return;
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $builder->insert($data);
    }

    public function down()
    {
        \Config\Database::connect()->table('jobs')->where('slug', self::SLUG)->delete();
    }
}
