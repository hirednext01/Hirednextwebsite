<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CvPayment extends BaseController
{
    public function qr()
    {
        $qrFile = FCPATH . 'theme/assets/hirednext-paytm-qr.jpg';

        if (!is_file($qrFile) || !is_readable($qrFile)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $qrBytes = file_get_contents($qrFile);
        if ($qrBytes === false || $qrBytes === '') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', 'image/jpeg')
            ->setHeader('Cache-Control', 'private, no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Pragma', 'no-cache')
            ->setBody($qrBytes);
    }

    public function checkout($leadId = null)
    {
        $db = \Config\Database::connect();
        $lead = $db->table('cv_assessment_leads')
            ->where('id', $leadId)
            ->where('assessment_plan', 'priority_599')
            ->get()
            ->getRowArray();

        if (!$lead) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('pages/services/cv-payment-direct', [
            'title' => 'Complete Payment | HiredNext',
            'currentPage' => 'services',
            'lead' => $lead,
        ]);
    }

    public function verify()
    {
        $leadId = (int) $this->request->getPost('lead_id');
        $paymentReference = trim((string) $this->request->getPost('payment_reference'));

        if (!$leadId || $paymentReference === '' || strlen($paymentReference) < 6) {
            return redirect()->back()->withInput()->with('errors', [
                'payment' => 'Please enter the UPI transaction/reference number shown by your payment app.'
            ]);
        }

        $db = \Config\Database::connect();
        $lead = $db->table('cv_assessment_leads')
            ->where('id', $leadId)
            ->where('assessment_plan', 'priority_599')
            ->get()
            ->getRowArray();

        if (!$lead) {
            return redirect()->to('/services/cv-assessment?payment=failed')
                ->with('errors', ['payment' => 'We could not find this CV assessment request.']);
        }

        $db->table('cv_assessment_leads')->where('id', $leadId)->update([
            'payment_id' => $paymentReference,
            'payment_status' => 'pending_verification',
            'status' => 'payment_submitted',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $email = \Config\Services::email();
        $email->setTo('tarushikha@hirednext.info');
        $email->setSubject('₹599 payment submitted for CV Assessment #' . $leadId);
        $email->setMessage(
            "A candidate has submitted a ₹599 UPI payment reference for verification.\n\n" .
            "Lead ID: {$leadId}\n" .
            "Name: " . ($lead['name'] ?? '') . "\n" .
            "Email: " . ($lead['email'] ?? '') . "\n" .
            "Phone: " . ($lead['phone'] ?? '') . "\n" .
            "UPI reference: {$paymentReference}\n" .
            "Amount: ₹599\n" .
            "Status: pending verification\n"
        );
        if (!$email->send()) {
            log_message('error', 'Priority CV payment notification failed for lead #' . $leadId);
        }

        return redirect()->to('/services/cv-assessment?payment=verification_pending')
            ->with('success', 'Thank you. Your payment reference has been received. We will verify the ₹599 payment and start your 12-hour priority CV assessment.');
    }
}
