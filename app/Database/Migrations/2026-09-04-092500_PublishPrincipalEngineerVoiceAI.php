<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PublishPrincipalEngineerVoiceAI extends Migration
{
    private const SLUG = 'principal-engineer-voice-ai-platform';

    public function up()
    {
        $db = \Config\Database::connect();

        if (!$db->tableExists('jobs') || !$db->tableExists('users')) {
            return;
        }

        $owner = $db->table('users')
            ->select('id')
            ->whereIn('role', ['admin', 'recruiter'])
            ->orderBy('id', 'ASC')
            ->get()
            ->getRowArray();

        if (empty($owner['id'])) {
            return;
        }

        $now = date('Y-m-d H:i:s');
        $job = [
            'title' => 'Principal Engineer — Voice AI Platform',
            'slug' => self::SLUG,
            'location' => 'Bengaluru or Noida',
            'type' => 'full-time',
            'department' => 'Engineering / Voice AI',
            'experience' => 'Principal / exceptional Staff level',
            'status' => 'open',
            'description' => <<<'HTML'
<p><strong>CONFIDENTIAL SEARCH</strong></p>
<p><strong>Ref: HN-2609-PEVAI</strong></p>
<p><strong>Build the future of conversations. Lead Voice AI that millions rely on.</strong></p>

<p>HiredNext is managing a confidential search for a profitable, established enterprise SaaS company building the next generation of its real-time Voice AI platform.</p>

<p>This is a <strong>Principal-level individual contributor role</strong> for someone who is still deeply hands-on with architecture, production code, debugging and platform performance. The mandate is broad and technically demanding.</p>

<p>You will help own the platform from an incoming SIP/WebRTC call through real-time speech processing, reasoning, orchestration and generated audio response.</p>

<h3>Location, work model and compensation</h3>
<ul>
    <li><strong>Location:</strong> Bengaluru or Noida</li>
    <li><strong>Work model:</strong> Hybrid — 3 days/week in office</li>
    <li><strong>Compensation:</strong> ₹1.5–2 crore fixed + performance-linked compensation + ESOPs</li>
    <li><strong>Search:</strong> Confidential</li>
</ul>

<h3>What you will own</h3>
<ul>
    <li>Own the next-generation real-time Voice AI platform.</li>
    <li>Work across SIP, RTP, WebRTC and speech-to-speech systems.</li>
    <li>Build and evolve STT–LLM–TTS pipelines and orchestration.</li>
    <li>Optimise GPU inference, latency, reliability and scale.</li>
    <li>Remain a deeply hands-on Principal IC working closely with the CTO and senior engineers.</li>
</ul>

<h3>Required production experience</h3>
<ul>
    <li>SIP, RTP, WebRTC and telephony-native media systems.</li>
    <li>Real-time Voice AI and speech-to-speech platforms.</li>
    <li>Streaming STT, LLM orchestration and TTS.</li>
    <li>Barge-in, VAD, endpointing and full-duplex interaction.</li>
    <li>Tool calling, RAG, workflow execution and human escalation.</li>
    <li>GPU inference and optimisation using stacks such as vLLM, Triton, TensorRT, CUDA, ONNX or Faster-Whisper.</li>
    <li>Distributed systems, Kubernetes, observability, fault tolerance and high-scale production operations.</li>
    <li>Measurable latency, concurrency, throughput or infrastructure-cost improvements.</li>
</ul>

<h3>This is not a conventional engineering-management role</h3>
<p>The successful candidate will work directly with the CTO and senior engineers while continuing to architect, code, troubleshoot and operate critical systems.</p>

<h3>We want evidence of what you personally built</h3>
<p>Strong applications should be able to answer questions such as:</p>
<ul>
    <li>What platform did you personally design?</li>
    <li>Which components did you personally code?</li>
    <li>What production scale did you operate?</li>
    <li>What were the real p95/p99 latency numbers?</li>
    <li>What difficult failure did you personally diagnose?</li>
    <li>What inference or infrastructure optimisation did you deliver, and what changed as a result?</li>
</ul>

<h3>Relevant backgrounds</h3>
<p>Exceptional candidates may come from Voice AI, Conversational AI, CPaaS, CCaaS, Cloud Telephony, WebRTC, Speech AI, ASR/TTS or large-scale distributed communications platforms.</p>

<p>Strong Staff-level engineers with unusually deep hands-on Voice AI and platform ownership may also be considered.</p>

<h3>How to apply confidentially</h3>
<p>Apply through the form on this page or email <strong>jobs@hirednext.info</strong>.</p>
<p>Please share:</p>
<ul>
    <li>CV</li>
    <li>LinkedIn profile</li>
    <li>GitHub / technical portfolio, where available</li>
    <li>Current location</li>
    <li>Current fixed and total compensation</li>
    <li>Expected fixed compensation</li>
    <li>Notice period</li>
    <li>Willingness to work 3 days/week from Bengaluru or Noida</li>
</ul>

<p><strong>Only evidence-based applications closely aligned with the mandate will be progressed.</strong></p>
<p>HiredNext never charges candidates to apply for a role or secure placement.</p>
HTML,
            'updated_at' => $now,
        ];

        $existing = $db->table('jobs')
            ->select('id')
            ->where('slug', self::SLUG)
            ->get()
            ->getRowArray();

        if ($existing) {
            $db->table('jobs')->where('id', $existing['id'])->update($job);
            return;
        }

        $job['created_by'] = (int) $owner['id'];
        $job['created_at'] = $now;
        $db->table('jobs')->insert($job);
    }

    public function down()
    {
        $db = \Config\Database::connect();

        if ($db->tableExists('jobs')) {
            $db->table('jobs')->where('slug', self::SLUG)->delete();
        }
    }
}
