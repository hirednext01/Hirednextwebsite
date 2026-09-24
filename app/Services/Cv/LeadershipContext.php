<?php

namespace App\Services\Cv;

/** Evidence for human service-fit review; never classify by tenure alone. */
class LeadershipContext
{
    public const FIELDS = [
        'leadership_level' => 'Current organisational level / title (required)',
        'leadership_scope' => 'Scale of responsibility (required)',
        'leadership_commercial' => 'Commercial / P&L ownership',
        'leadership_complexity' => 'Team and organisational complexity',
        'leadership_geography' => 'Geographic scope',
        'leadership_stakeholders' => 'Stakeholder level',
        'leadership_target' => 'Target role / mandate (required)',
        'leadership_transition' => 'Functional-to-enterprise transition, if relevant',
    ];

    public static function appendToMessage(array $input, string $message): string
    {
        $lines = ['Leadership context for service-fit review:'];
        foreach (self::FIELDS as $field => $label) {
            $raw = $input[$field] ?? '';
            $value = is_scalar($raw) ? trim((string) $raw) : '';
            $lines[] = $label . ': ' . ($value !== '' ? $value : 'Not provided');
        }
        $lines[] = 'Review on responsibility, scope and target mandate; do not classify by years of experience alone.';
        return implode("\n", $lines) . ($message !== '' ? "\n\nAdditional context:\n" . $message : '');
    }
}
