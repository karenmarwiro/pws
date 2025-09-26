<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * Provides a global HMVC-friendly view loader for Core and Module views.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Absolute path to Core views.
     *
     * @var string
     */
    protected $coreViewPath;

    /**
     * Array of module view paths.
     *
     * @var array
     */
    protected $modulePaths = [];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Initialize Core views path
        $this->coreViewPath = APPPATH . 'Core/Views/';

        // Automatically register all modules
        $modulesDir = APPPATH . 'Modules/';
        $modules = scandir($modulesDir);

        foreach ($modules as $module) {
            if ($module === '.' || $module === '..') continue;
            $this->modulePaths[$module] = $modulesDir . $module . '/Views/';
        }
    }

    /**
     * Load a view from Core views
     *
     * @param string $view
     * @param array $data
     * @return string
     */
    protected function coreView(string $view, array $data = []): string
    {
        $file = $this->coreViewPath . $view . '.php';
        if (! file_exists($file)) {
            throw new \RuntimeException("Core view not found: {$file}");
        }

        $coreViewPath = $this->coreViewPath; // make path available in view
        extract($data);
        ob_start();
        include $file;
        return ob_get_clean();
    }

    /**
     * Load a view from a module
     *
     * @param string $module
     * @param string $view
     * @param array $data
     * @return string
     */
    protected function moduleView(string $module, string $view, array $data = []): string
    {
        if (!isset($this->modulePaths[$module])) {
            throw new \RuntimeException("Module not registered: {$module}");
        }

        $file = $this->modulePaths[$module] . $view . '.php';
        if (! file_exists($file)) {
            throw new \RuntimeException("Module view not found: {$file}");
        }
        $coreViewPath = $this->coreViewPath; // make path available in view
        extract($data);
        ob_start();
        include $file;
        return ob_get_clean();
    }
}
