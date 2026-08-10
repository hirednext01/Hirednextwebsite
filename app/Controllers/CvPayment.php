<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CvPayment extends BaseController
{
    public function checkout($leadId = null)
    {
        $db = \Config\Database::connect();
        $lead = $db->table('cv_assessment_leads')->where('id', $leadId)->where('assessment_plan', 'priority_599')->get()->getRowArray();
        if (!$lead) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $keyId = (string) env('razorpay.keyId', '');
        $keySecret = (string) env('razorpay.keySecret', '');
        if ($keyId === '' || $keySecret === '') {
            return redirect()->to('/cv-assessment?payment=not_configured')->with('errors', ['payment' => 'Priority payment is temporarily unavailable while the payment gateway is being configured. Your request is saved.']);
        }

        if (!empty($lead['razorpay_order_id'])) {
            $orderId = $lead['razorpay_order_id'];
        } else {
            $payload = json_encode(['amount' => 59900, 'currency' => 'INR', 'receipt' => 'cv_' . $leadId, 'notes' => ['lead_id' => (string) $leadId]], JSON_UNESCAPED_SLASHES);
            $ch = curl_init('https://api.razorpay.com/v1/orders');
            curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_POST => true, CURLOPT_POSTFIELDS => $payload, CURLOPT_USERPWD => $keyId . ':' . $keySecret, CURLOPT_HTTPHEADER => ['Content-Type: application/json'], CURLOPT_TIMEOUT => 15]);
            $raw = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $order = json_decode((string) $raw, true);
            if ($status < 200 || $status >= 300 || empty($order['id'])) {
                log_message('error', 'Razorpay order creation failed: ' . $raw);
                return redirect()->to('/cv-assessment?payment=error')->with('errors', ['payment' => 'We could not start the payment. Please try again later.']);
            }
            $orderId = $order['id'];
            $db->table('cv_assessment_leads')->where('id', $leadId)->update(['amount' => 599, 'razorpay_order_id' => $orderId, 'updated_at' => date('Y-m-d H:i:s')]);
        }

        return view('pages/services/cv-payment', ['title' => 'Complete Payment | HiredNext', 'lead' => $lead, 'keyId' => $keyId, 'orderId' => $orderId]);
    }

    public function verify()
    {
        $leadId = (int) $this->request->getPost('lead_id');
        $paymentId = trim((string) $this->request->getPost('razorpay_payment_id'));
        $orderId = trim((string) $this->request->getPost('razorpay_order_id'));
        $signature = trim((string) $this->request->getPost('razorpay_signature'));
        $secret = (string) env('razorpay.keySecret', '');
        $expected = hash_hmac('sha256', $orderId . '|' . $paymentId, $secret);

        if (!$leadId || !$paymentId || !$orderId || !$signature || $secret === '' || !hash_equals($expected, $signature)) {
            return redirect()->to('/cv-assessment?payment=failed')->with('errors', ['payment' => 'Payment verification failed. Please contact HiredNext if your account was debited.']);
        }

        $db = \Config\Database::connect();
        $lead = $db->table('cv_assessment_leads')->where('id', $leadId)->where('razorpay_order_id', $orderId)->get()->getRowArray();
        if (!$lead) return redirect()->to('/cv-assessment?payment=failed');

        $db->table('cv_assessment_leads')->where('id', $leadId)->update(['payment_id' => $paymentId, 'payment_status' => 'paid', 'status' => 'paid', 'updated_at' => date('Y-m-d H:i:s')]);
        return redirect()->to('/cv-assessment?payment=success')->with('success', 'Payment received. Your 12-hour priority CV assessment is confirmed.');
    }
}
