<?php
$root = dirname(__DIR__);
$plans = file_get_contents($root . '/app/Services/Cv/CvUpgradePlans.php');
$routes = file_get_contents($root . '/app/Config/Routes.php');
$controller = file_get_contents($root . '/app/Controllers/CandidateServices.php');
$landing = file_get_contents($root . '/app/Views/pages/services/executive-cv.php');
$start = file_get_contents($root . '/app/Views/pages/services/cv-service-start.php');
$payment = file_get_contents($root . '/app/Views/pages/services/cv-upgrade-payment.php');
$creator = file_get_contents($root . '/app/Services/Cv/CvCreationAgent.php');
$delivery = file_get_contents($root . '/app/Controllers/CvStudioDocumentController.php');
$checks = [
 'fixed GST-inclusive plan' => str_contains($plans, "'executive_6999'") && str_contains($plans, "'amount' => 6999"),
 'public landing route' => str_contains($routes, "services/executive-cv") && str_contains($controller, 'function executiveCv'),
 'direct checkout' => str_contains($landing, "career-services/start/executive_6999"),
 'case study scope' => str_contains($landing, 'One defining chapter') && str_contains($landing, 'Decisions and actions attributable to you'),
 'evidence safeguards' => str_contains($landing, 'we do not manufacture achievements') && str_contains($start, 'numbers and achievements are never invented'),
 'GST display at intake and payment' => str_contains($start, "'executive_6999'") && str_contains($payment, '[1799, 6999]'),
 'paid generation and delivery gates' => str_contains($creator, "'executive_6999'") && str_contains($delivery, "'executive_6999'"),
];
$failed=[]; foreach($checks as $label=>$ok){ if(!$ok)$failed[]=$label; }
if($failed){fwrite(STDERR,'FAIL: '.implode(', ',$failed).PHP_EOL);exit(1);}
echo "PASS: executive CV product and paid fulfilment contract\n";

