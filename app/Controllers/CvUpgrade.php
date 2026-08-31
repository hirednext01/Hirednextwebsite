<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CvUpgradeOrderModel;
use App\Services\Cv\CvAuditService;
use App\Services\Cv\CvCandidateMailer;
use App\Services\Cv\CvUpgradePlans;

class CvUpgrade extends BaseController
{
    public function checkout(string $token)
    {
        [$order, $lead] = $this->loadOrder($token);
        return view('pages/services/cv-upgrade-payment', [
            'title' => 'Complete CV Service Payment | HiredNext',
            'metaDescription' => 'HiredNext CV service payment reference submission.',
            'canonical' => base_url('services/candidates'),
            'currentPage' => 'services',
            'settings' => $this->loadWebsiteSettings(),
            'order' => $order,
            'lead' => $lead,
            'plan' => CvUpgradePlans::get((string) $order['tier']),
        ]);
    }

    public function submit(string $token)
    {
        [$order, $lead] = $this->loadOrder($token);
        $email = trim((string) $this->request->getPost('email'));
        $reference = trim((string) $this->request->getPost('payment_reference'));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strcasecmp($email, (string) $lead['email']) !== 0) {
            return redirect()->back()->withInput()->with('error', 'Please enter the same email address used for your HiredNext CV request.');
        }
        if (strlen($reference) < 6) {
            return redirect()->back()->withInput()->with('error', 'Please enter the UPI transaction/reference number shown by your payment app.');
        }

        $now = date('Y-m-d H:i:s');
        $model = new CvUpgradeOrderModel();
        $model->update((int) $order['id'], [
            'status' => 'payment_submitted',
            'payment_reference' => $reference,
            'submitted_at' => $now,
            'updated_at' => $now,
        ]);
        $order = $model->find((int) $order['id']);

        (new CvAuditService())->record((int) $lead['id'], 'upgrade_payment_submitted', [
            'order_id' => $order['id'],
            'tier' => $order['tier'],
            'service_name' => $order['service_name'],
            'amount' => $order['amount'],
            'payment_reference' => $reference,
        ], null, 'web', 'pending_verification');

        $mailer = new CvCandidateMailer();
        $mailer->sendUpgradePaymentAcknowledgement($lead, $order);
        $mailer->sendInternalUpgradeAlert($lead, $order);

        return redirect()->to('/cv-upgrade/' . rawurlencode($token) . '?submitted=1')
            ->with('success', 'Thank you. HiredNext has received your payment reference. The transaction will be verified before the service moves into fulfilment.');
    }

    private function loadOrder(string $token): array
    {
        if (!preg_match('/^[a-f0-9]{48}$/i', $token)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $db = \Config\Database::connect();
        if (!$db->tableExists('cv_upgrade_orders')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $order = (new CvUpgradeOrderModel())->where('token', $token)->first();
        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $lead = $db->table('cv_assessment_leads')->where('id', (int) $order['lead_id'])->get()->getRowArray();
        if (!$lead) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return [$order, $lead];
    }
}
