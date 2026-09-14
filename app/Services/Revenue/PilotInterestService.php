<?php

namespace App\Services\Revenue;

/** Interest intake only. This service never creates an order or verifies payment. */
class PilotInterestService
{
    public const SUBJECT = 'PILOT: Interview Ready | INR 999 interest';

    public function capture($request, $db, $mailer): array
    {
        $name = trim((string) $request->getPost('name'));
        $address = strtolower(trim((string) $request->getPost('email')));
        $message = trim((string) $request->getPost('message'));
        if ($request->getPost('consent') !== 'interview_pilot_updates_only'
            || trim((string) $request->getPost('company_website')) !== ''
            || mb_strlen($name) < 3 || mb_strlen($name) > 100
            || strlen($address) > 100 || !filter_var($address, FILTER_VALIDATE_EMAIL)
            || mb_strlen($message) < 10 || mb_strlen($message) > 2200) {
            return ['status' => 'error', 'message' => 'Please check your details and email consent.'];
        }

        $ip = $request->getIPAddress();
        $now = date('Y-m-d H:i:s');
        $storedMessage = strip_tags($message);
        $existing = $db->table('contact_messages')
            ->where('subject', self::SUBJECT)->where('email', $address)
            ->where('message', $storedMessage)
            ->where('created_at >=', date('Y-m-d H:i:s', time() - 600))
            ->orderBy('id', 'DESC')->get()->getRowArray();
        if ($existing) {
            return ['status' => 'success', 'receipt' => 'HN-INTEREST-' . (int) $existing['id'],
                'duplicate' => true, 'email_status' => 'not_resent'];
        }

        $recent = $db->table('contact_messages')->where('subject', self::SUBJECT)
            ->where('ip_address', $ip)->where('created_at >=', date('Y-m-d H:i:s', time() - 3600))
            ->countAllResults();
        if ($recent >= 5) {
            return ['status' => 'error', 'message' => 'Please try again later.'];
        }

        $saved = $db->table('contact_messages')->insert([
            'name' => strip_tags($name), 'email' => $address,
            'subject' => self::SUBJECT, 'message' => $storedMessage,
            'status' => 'new', 'ip_address' => $ip,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $id = $saved ? (int) $db->insertID() : 0;
        if ($id < 1) {
            return ['status' => 'error', 'message' => 'We could not save your interest. Please try again later.'];
        }

        $receipt = 'HN-INTEREST-' . $id;
        $sent = false;
        try {
            $mailer->clear(true);
            $mailer->setFrom('jobs@hirednext.info', 'HiredNext');
            $mailer->setTo($address);
            if ($address !== 'jobs@hirednext.info') {
                $mailer->setBCC('jobs@hirednext.info');
            }
            $mailer->setReplyTo('jobs@hirednext.info', 'HiredNext');
            $mailer->setSubject('HiredNext Interview Ready interest recorded | ' . $receipt);
            \App\Services\HiredNextEmail::applyText($mailer, 'Your interest is recorded',
                "Hello " . strip_tags($name) . ",\n\n" .
                "Your interest in the proposed INR 999 Interview Ready service is recorded.\n" .
                "Reference: " . $receipt . "\n\n" .
                "This is an expression of interest. No payment has been taken and no order has been placed. " .
                "The pilot is not open for purchase. We will email you if it opens, with the confirmed scope and timing before you decide.\n\n" .
                "You can explore the sample and answers to common questions now:\n" .
                "https://hirednext.net/pilots/interview-ready.html#sample\n\n" .
                "Your submission:\n" . $storedMessage . "\n\n" .
                "Reply to this email if you have a question or would like us to stop pilot updates. " .
                "We will use these details for this pilot only. Your job applications are separate.\n\n" .
                "HiredNext Recruitment\nhttps://hirednext.net\n"
            );
            $sent = (bool) $mailer->send(false);
        } catch (\Throwable $e) {
            $sent = false;
        }
        if (!$sent) {
            // Do not log the candidate's details, SMTP headers or credentials.
            log_message('error', 'Interview Ready acknowledgement failed for contact ID {id}', ['id' => $id]);
        }
        return ['status' => 'success', 'receipt' => $receipt,
            'email_status' => $sent ? 'sent' : 'unconfirmed'];
    }
}
