<?php

namespace App\Core\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected $data = [];
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        // Initialize any common functionality here
        $this->initializeLanguage();
        
        // Load settings model if not already loaded
        $settingsModel = new \App\Core\Models\SettingsModel();
        $settings = $settingsModel->getAllSettings();
        
        // Update site name from settings if available
        if (!empty($settings['site_name'])) {
            $this->data['siteName'] = $settings['site_name'];
        }
    }
    
    /**
     * Initialize language settings
     */
    protected function initializeLanguage()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        
        // Get language from session, cookie, or default to English
        $language = $session->get('language') ?? 
                   $request->getCookie('language') ?? 'en';
        
        // Ensure the language is supported
        $supportedLanguages = ['en', 'es', 'fr', 'de'];
        if (!in_array($language, $supportedLanguages)) {
            $language = 'en';
        }
        
        // Set language in session and cookie
        $session->set('language', $language);
        $response = \Config\Services::response();
        $response->setCookie('language', $language, 60 * 60 * 24 * 30); // 30 days
        
        // Set the locale
        $request->setLocale($language);
        
        // Set the current language in the view data
        $this->data['language'] = $language;
        
        // Define available languages with their display names
        $this->data['languages'] = [
            'en' => 'English',
            'es' => 'Español',
            'fr' => 'Français',
            'de' => 'Deutsch'
        ];
        
        // Load necessary helpers
        helper(['url', 'language']);
        
        // Ensure the language file is loaded
        $languageFile = 'App';
        if (!lang($languageFile . '.language')) {
            // If the language file isn't loaded, load it
            $lang = \Config\Services::language();
            $lang->setLocale($language);
        }
    }
    
    /**
     * Render a view within the Core layout
     *
     * @param string $view
     * @param array $data
     * @return string
     */
    protected function coreView($view, array $data = [])
    {
        // Merge controller data with passed data
        $viewData = array_merge($this->data, $data);
        
        // Extract data to make variables available in included views
        extract($viewData);
        
        // Set the content view path
        $content = view('App\\Core\\Views\\' . $view, $viewData);
        
        // Make sure siteName is available in all views
        $siteName = $viewData['siteName'] ?? 'PWS';
        
        // Return the main layout with the content
        return view('App\\Core\\Views\\_layout', array_merge($viewData, [
            'content' => $content,
            'siteName' => $siteName,
            'language' => $language,
            'languages' => $viewData['languages']
        ]));
    }
    
    /**
     * Set the application language
     * 
     * @param string $language Language code (e.g., 'en', 'es')
     * @return void
     */
    protected function setLanguage($language)
    {
        $supportedLanguages = ['en', 'es', 'fr', 'de'];
        
        // Default to English if language is not supported
        if (!in_array($language, $supportedLanguages)) {
            $language = 'en';
        }
        
        // Set the language in session
        session()->set('language', $language);
        
        // Set the language for CodeIgniter
        $request = \Config\Services::request();
        $request->setLocale($language);
        
        // Load the language file
        $lang = \Config\Services::language();
        $lang->setLocale($language);
    }
    }

