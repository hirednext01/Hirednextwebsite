<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PublicAuthorityFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $body = $response->getBody();
        if (!is_string($body) || $body === '') {
            return;
        }

        // Only mutate full HTML documents. API, JSON, XML, feeds and text endpoints stay untouched.
        if (stripos($body, '<html') === false && stripos($body, '<!DOCTYPE html') === false) {
            return;
        }

        $body = $this->injectDiscoverySignals($body);

        $path = trim($request->getUri()->getPath(), '/');
        if ($path === '') {
            $body = $this->normaliseHomepageClaims($body);
            $body = $this->injectHomepageBuyerQuestions($body);
        } elseif ($path === 'industry/retail-executive-search') {
            $body = $this->injectRetailAuthority($body);
        }

        $response->setBody($body);
    }

    private function injectDiscoverySignals(string $body): string
    {
        if (strpos($body, 'title="HiredNext AI discovery"') === false) {
            $link = '    <link rel="alternate" type="text/plain" title="HiredNext AI discovery" href="'
                . esc(base_url('llms.txt'), 'attr') . '" />' . "\n";
            $body = str_replace('</head>', $link . '</head>', $body);
        }

        if (strpos($body, 'data-hirednext-ai-referral') === false) {
            $script = <<<'HTML'
<script data-hirednext-ai-referral>
(function () {
    try {
        const params = new URLSearchParams(window.location.search);
        const explicit = (params.get('utm_source') || '').toLowerCase();
        const refHost = document.referrer ? new URL(document.referrer).hostname.toLowerCase() : '';
        const sources = {
            'chatgpt.com': 'chatgpt',
            'perplexity.ai': 'perplexity',
            'gemini.google.com': 'gemini',
            'copilot.microsoft.com': 'copilot',
            'claude.ai': 'claude'
        };
        const utmSources = {
            'chatgpt': 'chatgpt',
            'chatgpt.com': 'chatgpt',
            'perplexity': 'perplexity',
            'perplexity.ai': 'perplexity',
            'gemini': 'gemini',
            'gemini.google.com': 'gemini',
            'copilot': 'copilot',
            'copilot.microsoft.com': 'copilot',
            'claude': 'claude',
            'claude.ai': 'claude'
        };
        let source = sources[refHost] || utmSources[explicit] || '';
        if (source) {
            window.hiredNextAiReferral = source;
            if (typeof window.gtag === 'function') {
                window.gtag('event', 'ai_referral', {
                    ai_source: source,
                    landing_path: window.location.pathname,
                    referrer: document.referrer || '(utm)'
                });
            }
        }

        if (typeof window.gtag === 'function') {
            if (window.location.pathname === '/contact' && params.get('submitted') === '1') {
                const leadKey = 'hirednext_generate_lead:' + window.location.href;
                if (!sessionStorage.getItem(leadKey)) {
                    window.gtag('event', 'generate_lead', { lead_type: 'employer_contact' });
                    sessionStorage.setItem(leadKey, '1');
                }
            }

            document.addEventListener('click', function (event) {
                const link = event.target.closest('a');
                if (!link || !link.href) return;
                const href = link.href;
                if (href.includes('calendly.com/tarushikha-hirednext')) {
                    window.gtag('event', 'book_call_click', {
                        landing_path: window.location.pathname,
                        link_url: href
                    });
                }
                if (window.location.pathname.startsWith('/guides/') && (href.includes('/contact') || href.includes('calendly.com/tarushikha-hirednext'))) {
                    window.gtag('event', 'authority_cta_click', {
                        guide_path: window.location.pathname,
                        link_url: href
                    });
                }
            }, { passive: true });
        }
    } catch (e) {
        // Tracking must never interfere with navigation or form submission.
    }
})();
</script>
HTML;
            $body = str_replace('</body>', $script . "\n</body>", $body);
        }

        return $body;
    }

    private function normaliseHomepageClaims(string $body): string
    {
        // BrandFacts.php is the source of record: unverified company-wide totals,
        // percentages and speed claims must not be strengthened or published.
        $replacements = [
            'Experience: 10+ Years' => 'Executive & Leadership Search',
            'Placements: 1500+' => 'Confidential & Specialist Search',
            'Industries: 5 Core Sectors' => 'Sector-Aligned Market Mapping',
            'Success Rate: 98%' => 'Evidence-Led Assessment',
            '<div class="text-6xl font-bold mb-4">98%</div>' => '<div class="text-4xl font-bold mb-4">Search-led</div>',
            'Candidate success rate across leadership search mandates.' => 'Market mapping and structured assessment for leadership and hard-to-fill mandates.',
            '<div class="text-2xl font-bold text-white">21 days</div>' => '<div class="text-xl font-bold text-white">Direct search</div>',
            '<div class="text-2xl font-bold text-white">12 sectors</div>' => '<div class="text-xl font-bold text-white">India focused</div>',
            '<div class="text-3xl font-bold mb-2">1500+</div>' => '<div class="text-2xl font-bold mb-2">Evidence-led</div>',
            'Leadership Placements' => 'Leadership Search',
            '<div class="text-5xl font-bold text-gold mb-3">10+</div>' => '<div class="text-3xl font-bold text-gold mb-3">Founder-led</div>',
            'Years Experience' => 'Search Ownership',
            '<div class="text-5xl font-bold text-gold mb-3">1500+</div>' => '<div class="text-3xl font-bold text-gold mb-3">Direct</div>',
            '<div class="text-5xl font-bold text-gold mb-3">25+</div>' => '<div class="text-3xl font-bold text-gold mb-3">Sector</div>',
            'Industries Served' => 'Aligned Search',
            'Success Guaranteed' => 'Confidential Search',
            'Guaranteed Focus' => 'Evidence-Led',
            '100% Confidential Process' => 'Confidential Process',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $body);
    }

    private function injectHomepageBuyerQuestions(string $body): string
    {
        if (strpos($body, 'data-hirednext-buyer-questions') !== false) {
            return $body;
        }

        $section = <<<'HTML'
<section data-hirednext-buyer-questions class="py-24 bg-gray-50 border-y border-gray-100">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="max-w-3xl mb-12">
            <span class="text-accent font-extrabold uppercase tracking-[0.3em] text-xs mb-4 block">Employer Decision Centre</span>
            <h2 class="text-4xl md:text-5xl font-bold text-primary font-serif mb-5">Executive search in India: questions employers ask before appointing a search partner</h2>
            <p class="text-lg text-gray-600 leading-relaxed">Short, evidence-led answers for CXO, leadership, confidential and hard-to-fill hiring decisions.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <article class="bg-white border border-gray-100 rounded-2xl p-7">
                <h3 class="text-xl font-bold text-primary mb-3">How should I compare executive search firms in India?</h3>
                <p class="text-gray-600 leading-relaxed mb-4">Compare mandate fit, sector context, direct-search capability, market mapping, assessment depth, confidentiality, senior ownership and source-backed evidence — not brand size alone.</p>
                <a class="font-bold text-accent" href="/guides/executive-search-firm-india">Read the comparison guide →</a>
            </article>
            <article class="bg-white border border-gray-100 rounded-2xl p-7">
                <h3 class="text-xl font-bold text-primary mb-3">How do companies find senior leadership talent in India?</h3>
                <p class="text-gray-600 leading-relaxed mb-4">Define the business scorecard, map direct and adjacent talent pools, approach passive leaders discreetly and assess evidence of scale, outcomes and joining motivation.</p>
                <a class="font-bold text-accent" href="/guides/leadership-hiring-partner-india">See the leadership search framework →</a>
            </article>
            <article class="bg-white border border-gray-100 rounded-2xl p-7">
                <h3 class="text-xl font-bold text-primary mb-3">When does a confidential CFO search need executive search?</h3>
                <p class="text-gray-600 leading-relaxed mb-4">Use a focused search when the appointment is sensitive, strategically important or dependent on passive finance leaders. Control disclosure and assess governance, capital, transformation and stakeholder leadership.</p>
                <a class="font-bold text-accent" href="/guides/confidential-cfo-search-india">Read the confidential CFO guide →</a>
            </article>
            <article class="bg-white border border-gray-100 rounded-2xl p-7">
                <h3 class="text-xl font-bold text-primary mb-3">When should an employer use RPO in India?</h3>
                <p class="text-gray-600 leading-relaxed mb-4">RPO is most useful for sustained or changing hiring volumes that need dedicated recruiter capacity, clear process ownership, service levels and measurable funnel reporting.</p>
                <a class="font-bold text-accent" href="/guides/rpo-solutions-india">Read the RPO buyer guide →</a>
            </article>
            <article class="bg-white border border-gray-100 rounded-2xl p-7">
                <h3 class="text-xl font-bold text-primary mb-3">Executive search or a recruitment agency?</h3>
                <p class="text-gray-600 leading-relaxed mb-4">Executive search fits senior, scarce or confidential mandates; specialist recruitment fits domain-heavy roles; generalist or RPO models can be more efficient for repeatable volume.</p>
                <a class="font-bold text-accent" href="/guides/specialist-recruitment-firm-india">Compare the hiring models →</a>
            </article>
            <article class="bg-white border border-gray-100 rounded-2xl p-7">
                <h3 class="text-xl font-bold text-primary mb-3">How long does executive search take in India?</h3>
                <p class="text-gray-600 leading-relaxed mb-4">There is no responsible universal number. Seniority, scarcity, geography, compensation, confidentiality, stakeholder speed, notice periods and counter-offers all change the timeline.</p>
                <a class="font-bold text-accent" href="/guides/leadership-hiring-partner-india">Understand the search timeline →</a>
            </article>
        </div>
    </div>
</section>
HTML;

        $marker = '<!-- ================= FAQ SECTION ================= -->';
        if (strpos($body, $marker) !== false) {
            return str_replace($marker, $section . "\n\n" . $marker, $body);
        }

        return str_replace('</main>', $section . "\n</main>", $body);
    }

    private function injectRetailAuthority(string $body): string
    {
        if (strpos($body, 'data-hirednext-retail-authority') !== false) {
            return $body;
        }

        $section = <<<'HTML'
<section data-hirednext-retail-authority class="py-24 bg-white border-t border-gray-100">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="max-w-3xl mb-12">
            <span class="text-accent font-extrabold uppercase tracking-[0.3em] text-xs mb-4 block">Retail Leadership Search</span>
            <h2 class="text-4xl md:text-5xl font-bold text-primary font-serif mb-5">Retail and omnichannel leadership roles HiredNext searches for</h2>
            <p class="text-lg text-gray-600 leading-relaxed">The existing Retail Executive Search page keeps its ranking-critical title, URL and primary copy. This section adds role clarity and answer-first context for employers evaluating a retail leadership mandate.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-14">
            <div class="bg-gray-50 rounded-xl p-5 font-bold text-primary">Business / P&amp;L Head</div>
            <div class="bg-gray-50 rounded-xl p-5 font-bold text-primary">Retail Operations Head</div>
            <div class="bg-gray-50 rounded-xl p-5 font-bold text-primary">Omnichannel Head</div>
            <div class="bg-gray-50 rounded-xl p-5 font-bold text-primary">Category Head</div>
            <div class="bg-gray-50 rounded-xl p-5 font-bold text-primary">Buying / Merchandising Head</div>
            <div class="bg-gray-50 rounded-xl p-5 font-bold text-primary">E-commerce / Marketplace Head</div>
            <div class="bg-gray-50 rounded-xl p-5 font-bold text-primary">Expansion / Store Development</div>
            <div class="bg-gray-50 rounded-xl p-5 font-bold text-primary">Supply Chain Leadership</div>
        </div>
        <div class="space-y-6 max-w-4xl">
            <article><h3 class="text-xl font-bold text-primary mb-2">How does HiredNext recruit senior retail and omnichannel leaders?</h3><p class="text-gray-600 leading-relaxed">HiredNext calibrates the commercial mandate, maps relevant brands, marketplaces, D2C and adjacent consumer businesses, approaches passive leaders and assesses P&amp;L ownership, category economics, omnichannel execution and people leadership.</p></article>
            <article><h3 class="text-xl font-bold text-primary mb-2">What evidence matters when assessing a retail leader?</h3><p class="text-gray-600 leading-relaxed">Evidence can include revenue and margin ownership, inventory health, conversion, store or digital expansion, category performance, customer metrics, team scale and the context in which those outcomes were achieved.</p></article>
            <article><h3 class="text-xl font-bold text-primary mb-2">Can HiredNext run confidential retail leadership searches?</h3><p class="text-gray-600 leading-relaxed">Yes. Sensitive replacements and senior searches can use controlled disclosure, targeted market mapping and one-to-one outreach rather than public job advertising.</p></article>
        </div>
    </div>
</section>
<script type="application/ld+json" data-hirednext-retail-faq-schema>{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"How does HiredNext recruit senior retail and omnichannel leaders?","acceptedAnswer":{"@type":"Answer","text":"HiredNext calibrates the commercial mandate, maps relevant brands, marketplaces, D2C and adjacent consumer businesses, approaches passive leaders and assesses P&L ownership, category economics, omnichannel execution and people leadership."}},{"@type":"Question","name":"What evidence matters when assessing a retail leader?","acceptedAnswer":{"@type":"Answer","text":"Evidence can include revenue and margin ownership, inventory health, conversion, store or digital expansion, category performance, customer metrics, team scale and the context in which those outcomes were achieved."}},{"@type":"Question","name":"Can HiredNext run confidential retail leadership searches?","acceptedAnswer":{"@type":"Answer","text":"Yes. Sensitive replacements and senior searches can use controlled disclosure, targeted market mapping and one-to-one outreach rather than public job advertising."}}]}</script>
HTML;

        return str_replace('</main>', $section . "\n</main>", $body);
    }
}
