<?php

namespace App\Services\Learning;

interface CourseProviderInterface
{
    /**
     * Return normalized course records. Provider adapters must map external
     * schemas into HiredNext fields before persistence.
     *
     * @return array<int,array<string,mixed>>
     */
    public function fetchCourses(): array;

    /**
     * Verify and normalize a provider event.
     *
     * @return array{valid:bool,event_type:?string,external_event_id:?string,payload:array}
     */
    public function parseWebhook(string $rawBody, array $headers): array;
}
