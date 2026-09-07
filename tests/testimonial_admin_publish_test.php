<?php

$root = dirname(__DIR__);
$routes = file_get_contents($root . '/app/Config/Routes.php');
$controller = @file_get_contents($root . '/app/Controllers/TestimonialAdmin.php');
$publicView = file_get_contents($root . '/app/Views/pages/testimonials.php');
$card = file_get_contents($root . '/app/Views/components/testimonial-card.php');
$legacy = @file_get_contents($root . '/app/Config/HistoricalTestimonials.php');
$reputation = file_get_contents($root . '/app/Controllers/ReputationAuthority.php');

$checks = [
    [$routes, "admin/testimonials", 'Admin testimonial route is missing.'],
    [$controller, 'cv_review_admin_user', 'Testimonials admin must reuse the existing admin session.'],
    [$controller, "status' => 'active'", 'Testimonials admin must support publishing.'],
    [$controller, "status' => 'rejected'", 'Testimonials admin must support rejection.'],
    [$publicView, 'Client & hiring leader proof', 'Premium employer testimonial section is missing.'],
    [$publicView, 'Placed candidate stories', 'Placed candidate section is missing.'],
    [$card, 'LinkedIn profile', 'LinkedIn authenticity link is missing.'],
    [$card, 'Placement through HiredNext', 'Placement evidence is missing.'],
    [$legacy, 'Shripad Tokekar', 'Shripad historical testimonial is missing.'],
    [$legacy, 'Shefi Gupta', 'Shefi historical testimonial is missing.'],
    [$legacy, 'Ranjan', 'Ranjan historical testimonial is missing.'],
    [$legacy, 'Aman Yadav', 'Aman historical testimonial is missing.'],
    [$legacy, 'Shyamlee', 'Shyamlee historical testimonial is missing.'],
    [$legacy, 'Nidhi Pande', 'Nidhi historical testimonial is missing.'],
    [$legacy, 'Md. Arif Uddin', 'Arif historical testimonial is missing.'],
    [$reputation, '/admin/testimonials/', 'New testimonial email must link directly to admin review.'],
];

foreach ($checks as [$haystack, $needle, $message]) {
    if (!is_string($haystack) || strpos($haystack, $needle) === false) {
        fwrite(STDERR, $message . "\n");
        exit(1);
    }
}

$clientHeadingCount = substr_count($publicView, 'Client & hiring leader proof');
if ($clientHeadingCount !== 1) {
    fwrite(STDERR, "Client testimonial section must appear exactly once.\n");
    exit(1);
}

if (strpos($publicView, 'Professional and career-support feedback') !== false) {
    fwrite(STDERR, "Legacy third testimonial bucket must not render on the public page.\n");
    exit(1);
}

echo "Testimonial admin + publishing contract: PASS\n";
