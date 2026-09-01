<?php

namespace App\Services\Revenue;

class SlackEventGuard
{
    private string $directory;

    public function __construct(?string $directory = null)
    {
        $this->directory = $directory ?? (defined('WRITEPATH') ? WRITEPATH . 'cache/revenue-council' : sys_get_temp_dir() . '/hirednext-revenue-council');
    }

    public function acquire(string $eventId): bool
    {
        if ($eventId === '') {
            return true;
        }
        if (!is_dir($this->directory)) {
            @mkdir($this->directory, 0775, true);
        }
        $path = $this->path($eventId);
        if (is_file($path) && (time() - (int) @filemtime($path)) > 86400) {
            @unlink($path);
        }
        $handle = @fopen($path, 'x');
        if ($handle === false) {
            return false;
        }
        fwrite($handle, (string) time());
        fclose($handle);
        return true;
    }

    public function release(string $eventId): void
    {
        if ($eventId !== '') {
            @unlink($this->path($eventId));
        }
    }

    private function path(string $eventId): string
    {
        return rtrim($this->directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . hash('sha256', $eventId) . '.lock';
    }
}
