<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

/**
 * Filter configuration
 */
class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf'             => CSRF::class,
        'toolbar'          => DebugToolbar::class,
        'honeypot'         => Honeypot::class,
        'invalidchars'     => InvalidChars::class,
        'secureheaders'    => SecureHeaders::class,
        'cors'             => \App\Filters\CorsFilter::class,
        'publicauthority'  => \App\Filters\PublicAuthorityFilter::class,
        'humanauthority'   => \App\Filters\HumanAuthorityLinksFilter::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     */
    public array $globals = [
        'before' => [
            'cors',
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'publicauthority',
            'humanauthority',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on any
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     */
    public array $filters = [
        'cors' => ['before' => ['api/*']],
    ];

    public function __construct()
    {
        parent::__construct();

        // Debug toolbar injects non-crawlable anchors, which hurts SEO audits.
        // Only enable it for local development requests by default.
        $host = (string) ($_SERVER['HTTP_HOST'] ?? '');
        $hostOnly = strtolower(trim(explode(':', $host, 2)[0]));
        $isLocalHost = in_array($hostOnly, ['localhost', '127.0.0.1', '::1'], true);

        if (
            defined('ENVIRONMENT')
            && ENVIRONMENT !== 'production'
            && $isLocalHost
        ) {
            $this->globals['after'][] = 'toolbar';
        }
    }
}
