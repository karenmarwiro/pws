<?php

namespace App\Core\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class FrontendController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically.
     *
     * @var array
     */
    protected $helpers = ['url', 'form', 'html'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        // Load any additional services or libraries here
        $this->session = \Config\Services::session();
    }

    /**
     * Render a view with common layout
     *
     * @param string $view
     * @param array $data
     * @return string
     */
    protected function render($view, $data = [])
    {
        // Set default data that should be available in all views
        $data['siteName'] = 'My Application';
        $data['currentYear'] = date('Y');
        
        // Add authentication status to the view data
        $data['isLoggedIn'] = $this->isLoggedIn();
        $data['userId'] = $this->getUserId();
        
        return view('app/Modules/Frontend/Views/partials/header', $data)
             . view($view, $data)
             . view('app/Modules/Frontend/Views/partials/footer');
    }


}