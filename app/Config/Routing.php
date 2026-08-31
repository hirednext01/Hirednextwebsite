<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use CodeIgniter\Config\Routing as BaseRouting;

/**
 * Routing configuration
 */
class Routing extends BaseRouting
{
    /**
     * For Defined Routes.
     * An array of files that contain route definitions.
     * Route files are read in order, with the first match
     * found taking precedence.
     *
     * @var list<string>
     */
    public array $routeFiles = [
        APPPATH . 'Config/Routes.php',
        APPPATH . 'Config/RoutesCvStudio.php',
    ];

    public string $defaultNamespace = 'App\\Controllers';
    public string $defaultController = 'Home';
    public string $defaultMethod = 'index';
    public bool $translateURIDashes = false;
    public ?string $override404 = null;
    public bool $autoRoute = false;
    public bool $prioritize = false;
    public bool $multipleSegmentsOneParam = false;

    /** @var array<string, string> */
    public array $moduleRoutes = [];

    public bool $translateUriToCamelCase = true;
}
