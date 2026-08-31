<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class NotifyCvReview extends BaseCommand
{
    protected $group = 'HiredNext';
    protected $name = 'cv:notify';
    protected $description = 'Resend internal and candidate emails for an existing CV review request.';
    protected $usage = 'cv:notify <lead_id>';
    protected $arguments = ['lead_id' => 'CV assessment lead ID.'];

    public function run(array $params)
    {
        $leadId = isset($params[0]) ? (int)$params[0] : 0;
        if ($leadId < 1) {
            CLI::error('Usage: php spark cv:notify <lead_id>');
            return;
        }

        $db = \Config\Database::connect();
        $lead = $db->table('cv_assessment_leads')->where('id', $leadId)->get()->getRowArray();
        if (!$lead) {
            CLI::error('CV review request #' . $leadId . ' was not found.');
            return;
        }

        $priority = ($lead['assessment_plan'] ?? '') === 'priority_599';
        $service = $priority ? '₹599 Priority CV Assessment / 12 hours' : 'Free CV Assessment / 7–10 days';
        $resumePath = ROOTPATH . ltrim((string)($lead['resume_path'] ?? ''), '/');

        $email = \Config\Services::email();
        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo('tarushikha@hirednext.info');
        $email->setReplyTo($lead['email'] ?? 'jobs@hirednext.info', $lead['name'] ?? 'Candidate');
        $email->setSubject('ACTION: CV review request #' . $leadId . ' — ' . ($lead['name'] ?? 'Candidate'));
        $email->setMessage(
            "HIREDNEXT CV REVIEW REQUEST\n\n" .
            "Lead ID: {$leadId}\n" .
            "Name: " . ($lead['name'] ?? '') . "\n" .
            "Email: " . ($lead['email'] ?? '') . "\n" .
            "Phone: " . ($lead['phone'] ?? '') . "\n" .
            "Service: {$service}\n" .
            "Payment status: " . ($lead['payment_status'] ?? '') . "\n" .
            "UPI reference: " . (($lead['payment_id'] ?? '') ?: '—') . "\n" .
            "Submitted: " . ($lead['created_at'] ?? '') . "\n\n" .
            "Message:\n" . (($lead['message'] ?? '') ?: '—')
        );
        if ($resumePath !== ROOTPATH && is_file($resumePath) && is_readable($resumePath)) {
            $email->attach($resumePath);
        }
        $internalSent = $email->send(false);

        $email->clear(true);
        $email->setFrom('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setTo($lead['email']);
        $email->setReplyTo('jobs@hirednext.info', 'HiredNext Jobs');
        $email->setSubject('We have received your CV review request | HiredNext');

        $candidateMessage =
            "Dear " . ($lead['name'] ?? 'Candidate') . ",\n\n" .
            "Thank you for asking HiredNext to review your CV. Your request #{$leadId} is recorded with us.\n\n" .
            "Service: {$service}\n";

        if ($priority && in_array(($lead['payment_status'] ?? ''), ['pending_verification', 'verified', 'paid'], true)) {
            $candidateMessage .= "Payment reference received: " . (($lead['payment_id'] ?? '') ?: 'submitted') . "\nStatus: " . ($lead['payment_status'] ?? '') . "\n\n";
        } elseif ($priority) {
            $candidateMessage .= "Payment status: awaiting payment\nPayment page: " . base_url('cv-payment/' . $leadId) . "\n\n";
        } else {
            $candidateMessage .= "Your CV is in the free 7–10 day review queue.\n\n";
        }

        $candidateMessage .=
            "HiredNext never charges candidates to apply for jobs or secure placement. CV review is an optional professional advisory service.\n\n" .
            "Regards,\nHiredNext Jobs Team\njobs@hirednext.info\nhttps://hirednext.net\n";

        $email->setMessage($candidateMessage);
        $candidateSent = $email->send(false);

        CLI::write('Internal alert to tarushikha@hirednext.info: ' . ($internalSent ? 'SENT' : 'FAILED'), $internalSent ? 'green' : 'red');
        CLI::write('Candidate acknowledgement to ' . ($lead['email'] ?? '') . ': ' . ($candidateSent ? 'SENT' : 'FAILED'), $candidateSent ? 'green' : 'red');
    }
}
