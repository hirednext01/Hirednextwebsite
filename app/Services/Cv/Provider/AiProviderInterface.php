<?php

namespace App\Services\Cv\Provider;

interface AiProviderInterface
{
    public function name(): string;

    public function configured(): bool;

    /**
     * @return array{reviewer:string,summary:string,scores:array,findings:array,strengths:array,usage?:array}
     */
    public function review(string $cvText, array $context = []): array;
}
