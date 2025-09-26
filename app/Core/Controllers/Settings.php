<?php

namespace App\Core\Controllers;

use App\Core\Models\SettingsModel;
use CodeIgniter\HTTP\RedirectResponse;

class Settings extends AdminController
{
    protected $settingsModel;

    public function __construct()
    {
        $this->settingsModel = new SettingsModel();
    }
    
 /**
 * Set the application language
 * 
 * @param string $language Language code (e.g., 'en', 'es')
 * @return array
 */
protected function setLanguage($language)
{
    $session = \Config\Services::session();
    
    // Ensure the language is supported
    $supportedLanguages = ['en', 'es', 'fr', 'de'];
    if (!in_array($language, $supportedLanguages)) {
        return [
            'success' => false,
            'message' => lang('App.language_not_supported')
        ];
    }
    
    try {
        // Save language preference using the model
        $saved = $this->settingsModel->setSetting('language', $language, 'App', 'string', 'general');
        
        if (!$saved) {
            throw new \RuntimeException('Failed to save language setting');
        }
        
        // Update session and application settings
        $this->updateSessionSettings();
        
        return [
            'success' => true,
            'message' => lang('App.language_changed'),
            'reload' => true
        ];
        
    } catch (\Exception $e) {
        log_message('error', 'Error setting language: ' . $e->getMessage());
        return [
            'success' => false,
            'message' => lang('App.language_change_error') . ': ' . $e->getMessage()
        ];
    }
}

    public function index()
    {
        // Get all settings
        $settings = $this->settingsModel->getAllSettings();
        
        // Set default values if not exists
        $defaults = [
            'site_name' => 'PWS Prototype',
            'site_url' => 'https://example.com',
            'admin_email' => 'admin@example.com',
            'timezone' => 'UTC',
            'language' => 'en_US',
            'theme' => 'default',
            'sidebar_style' => 'expanded',
            'siteName' => 'PWS', // Add this line to ensure siteName is always set
            'color_scheme' => 'light',
            'email_notifications' => true,
            'browser_notifications' => false,
            'desktop_notifications' => false,
            'notification_sound' => 'default'
        ];

        // Get the scripts content
        $scripts = view('App\Core\Views\settings\_settings_scripts', [
            'settings' => array_merge($defaults, $settings)
        ]);
        
        // Get current language from session or settings
        $language = session('language') ?? ($settings['language'] ?? 'en');
        
        // Define available languages
        $languages = [
            'en' => 'English',
            'es' => 'Español',
            'fr' => 'Français',
            'de' => 'Deutsch'
        ];
        
        // Merge with saved settings
        $data = [
            'title' => 'System Settings',
            'settings' => array_merge($defaults, $settings),
            'siteName' => $settings['site_name'] ?? 'PWS',  // Ensure siteName is set
            'scripts' => $scripts,
            'language' => $language,
            'languages' => $languages
        ];
        
        // Use the coreView method from BaseController
        return $this->coreView('settings/index', $data);
    }

    /**
     * Save settings from the form
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function saveSetting()
    {
        // Enable detailed error logging
        $logPath = WRITEPATH . 'logs/settings_debug.log';
        $logMessage = "[" . date('Y-m-d H:i:s') . "] Starting settings save process\n";
        
        // Log request method and URI
        $logMessage .= "Request Method: " . $this->request->getMethod() . "\n";
        $logMessage .= "Request URI: " . $this->request->getUri() . "\n";
        
        // Log all headers
        $logMessage .= "Headers: " . print_r($this->request->headers(), true) . "\n";
        
        // Log raw input
        $rawInput = $this->request->getBody();
        $logMessage .= "Raw input: " . $rawInput . "\n";
        
        // Check if this is an AJAX request
        $isAjax = $this->request->isAJAX();
        $logMessage .= "Is AJAX request: " . ($isAjax ? 'Yes' : 'No') . "\n";
        
        if (!$isAjax) {
            $logMessage .= "Error: Non-AJAX request detected\n";
            file_put_contents($logPath, $logMessage, FILE_APPEND);
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'This endpoint only accepts AJAX requests',
                'data' => []
            ])->setStatusCode(400);
        }

        // Get input data
        $input = [];
        $contentType = $this->request->getHeaderLine('Content-Type') ?? '';
        $logMessage .= "Content-Type: " . $contentType . "\n";
        
        // Log all available request data
        $logMessage .= "POST data: " . print_r($_POST, true) . "\n";
        $logMessage .= "GET data: " . print_r($_GET, true) . "\n";
        $logMessage .= "FILES data: " . print_r($_FILES, true) . "\n";
        
        // Handle JSON input
        if (strpos($contentType, 'application/json') !== false) {
            $input = $this->request->getJSON(true) ?? [];
            $logMessage .= "Parsed JSON input: " . print_r($input, true) . "\n";
        } 
        // Handle form data
        else {
            $input = $this->request->getPost();
            $logMessage .= "Form POST input: " . print_r($input, true) . "\n";
            
            // If no POST data, try getting raw input
            if (empty($input) && !empty($rawInput)) {
                $input = json_decode($rawInput, true) ?? [];
                $logMessage .= "Parsed raw input: " . print_r($input, true) . "\n";
            }
        }
        
        // Log the final input data
        $logMessage .= "Final input data: " . print_r($input, true) . "\n";
        
        // Log CSRF token status
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN') ?: ($_POST['csrf_test_name'] ?? '');
        $logMessage .= "CSRF Token: " . (!empty($csrfToken) ? 'Provided' : 'Missing') . "\n";
        
        // Save the log
        file_put_contents($logPath, $logMessage, FILE_APPEND);

        // Check if we have file uploads
        $files = $this->request->getFiles();
        if (!empty($files)) {
            foreach ($files as $field => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $uploadPath = ROOTPATH . 'public/uploads/';
                    
                    // Create uploads directory if it doesn't exist
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    
                    // Move the file to the uploads directory
                    $file->move($uploadPath, $newName);
                    $input[$field] = 'uploads/' . $newName;
                }
            }
        }

        // Handle theme change
        if (isset($input['theme'])) {
            return $this->handleThemeChange($input['theme']);
        }

        // Handle language change
        if (isset($input['language'])) {
            $result = $this->setLanguage($input['language']);
            return $this->response->setJSON([
                'success' => $result['success'],
                'message' => $result['message'],
                'reload' => true
            ]);
        }

        // Process settings
        $result = $this->processSettings($input);
        
        // Clear settings cache
        if (function_exists('cache')) {
            cache()->delete('app_settings');
            cache()->delete('app_settings_all');
        }
        
        // Update session with new settings
        $this->updateSessionSettings();

        return $this->response->setJSON($result);
    }

/**
 * Process and save settings
 *
 * @param array $input
 * @return array
 */
protected function processSettings($input)
{
    try {
        // Process checkboxes
        $checkboxes = [
            'email_notifications', 
            'browser_notifications', 
            'desktop_notifications',
            'remove_logo',
            'remove_favicon'
        ];
        
        foreach ($checkboxes as $checkbox) {
            $input[$checkbox] = isset($input[$checkbox]) ? 1 : 0;
        }

        // Handle file uploads
        $fileFields = ['logo', 'favicon'];
        foreach ($fileFields as $field) {
            $removeField = 'remove_' . $field;
            
            // If remove checkbox is checked, clear the file
            if (!empty($input[$removeField])) {
                $existingFile = $this->settingsModel->getSetting($field);
                if ($existingFile && file_exists(ROOTPATH . 'public/' . $existingFile)) {
                    unlink(ROOTPATH . 'public/' . $existingFile);
                }
                $input[$field] = '';
            } 
            // Handle new file upload
            elseif (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                $file = $this->request->getFile($field);
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $uploadPath = ROOTPATH . 'public/uploads/';
                    
                    // Create uploads directory if it doesn't exist
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    
                    // Move the file to the uploads directory
                    $file->move($uploadPath, $newName);
                    $input[$field] = 'uploads/' . $newName;
                }
            }
            // Keep existing file if no new file uploaded and not removing
            elseif (empty($input[$field])) {
                $existingFile = $this->settingsModel->getSetting($field);
                $input[$field] = $existingFile ?? '';
            }
        }

        // Default values
        $defaults = [
            'site_name' => 'PWS Prototype',
            'site_url' => base_url(),
            'admin_email' => 'admin@example.com',
            'timezone' => 'UTC',
            'language' => 'en',
            'theme' => 'default',
            'sidebar_style' => 'expanded',
            'color_scheme' => 'light',
            'notification_sound' => 'default',
            'email_notifications' => 1,
            'browser_notifications' => 0,
            'desktop_notifications' => 0,
            'logo' => '',
            'favicon' => ''
        ];

        // Filter input to only include allowed fields
        $settingsToSave = [];
        foreach (array_keys($defaults) as $key) {
            if (array_key_exists($key, $input)) {
                $settingsToSave[$key] = $input[$key];
            }
        }

        // Required fields validation
        $requiredFields = ['site_name', 'admin_email', 'timezone', 'language'];
        foreach ($requiredFields as $field) {
            if (empty($settingsToSave[$field])) {
                throw new \RuntimeException("Required field '$field' is missing or empty");
            }
        }

        // Save all settings in a single transaction
        $saved = $this->settingsModel->setSettings($settingsToSave, 'App', 'general');

        if (!$saved) {
            return [
                'success' => false,
                'message' => 'Failed to save settings',
                'data' => []
            ];
        }

        return [
            'success' => true,
            'message' => lang('App.settings_save_success'),
            'data' => array_merge($defaults, $settingsToSave)
        ];

    } catch (\Exception $e) {
        log_message('error', 'Error in processSettings: ' . $e->getMessage());
        
        return [
            'success' => false,
            'message' => $e->getMessage(),
            'data' => []
        ];
    }
}

/**
 * Handle theme change
 *
 * @param string $theme
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
protected function handleThemeChange($theme)
{
    $supportedThemes = ['default', 'dark', 'light', 'blue'];
    if (!in_array($theme, $supportedThemes)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Unsupported theme selected',
            'data' => []
        ]);
    }

    // Save theme preference
    $saved = $this->settingsModel->setSetting('theme', $theme, 'App', 'string', 'general');
    
    if ($saved) {
        $this->updateSessionSettings();
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Theme updated successfully',
            'data' => ['theme' => $theme]
        ]);
    }

    return $this->response->setJSON([
        'success' => false,
        'message' => 'Failed to save theme preference',
        'data' => []
    ]);
}
    
    /**
     * Handle file uploads
     */
    protected function handleFileUpload($fieldName)
    {
        $file = $this->request->getFile($fieldName);
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadPath = WRITEPATH . 'uploads/settings/';
            
            // Create directory if it doesn't exist
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            if ($file->move($uploadPath, $newName)) {
                return 'uploads/settings/' . $newName;
            }
        }
        
        return null;
    }
    
    /**
     * Update session with the latest settings
     */
    /**
 * Update session with the latest settings
 */
protected function updateSessionSettings()
{
    // Get all settings from the model
    $settings = $this->settingsModel->getAllSettings();
    
    // Default values
    $defaults = [
        'site_name' => 'PWS Prototype',
        'site_url' => base_url(),
        'admin_email' => 'admin@example.com',
        'timezone' => 'UTC',
        'language' => 'en',
        'theme' => 'default',
        'sidebar_style' => 'expanded',
        'color_scheme' => 'light',
        'notification_sound' => 'default',
        'email_notifications' => 1,
        'browser_notifications' => 0,
        'desktop_notifications' => 0
    ];
    
    // Merge with defaults
    $settings = array_merge($defaults, $settings);
    
    // Update the session
    $session = \Config\Services::session();
    $session->set('settings', $settings);
    
    // Set individual session variables for quick access
    $session->set([
        'siteName' => $settings['site_name'],
        'adminEmail' => $settings['admin_email'],
        'timezone' => $settings['timezone'],
        'language' => $settings['language'],
        'theme' => $settings['theme'],
        'color_scheme' => $settings['color_scheme']
    ]);
    
    // Set the application locale
    $request = \Config\Services::request();
    $request->setLocale($settings['language']);
    
    // Set the timezone
    date_default_timezone_set($settings['timezone']);
    
    // Set language service
    $language = \Config\Services::language();
    $language->setLocale($settings['language']);
    
    // Set language cookie (30 days)
    $response = \Config\Services::response();
    $response->setCookie('language', $settings['language'], 60 * 60 * 24 * 30);
    
    return $settings;
}
    public function getSetting($key, $default = null)
    {
        $setting = $this->where('key', $key)->first();
        return $setting ? $this->unserializeIfNeeded($setting['value'], $setting['type'] ?? 'string') : $default;
    }
    
    /**
     * Set a setting value
     */
    public function setSetting($key, $value, $class = 'App', $type = 'string', $context = 'general')
    {
        $data = [
            'class' => $class,
            'key' => $key,
            'value' => $this->serializeIfNeeded($value, $type),
            'type' => $type,
            'context' => $context,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $existing = $this->where('key', $key)->first();
        
        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            return $this->insert($data);
        }
    }
    
    /**
     * Get all settings as an associative array
     */
    public function getAllSettings()
    {
        $settings = [];
        $result = $this->findAll();
        
        foreach ($result as $row) {
            $settings[$row['key']] = $this->unserializeIfNeeded($row['value'], $row['type'] ?? 'string');
        }
        
        return $settings;
    }
    
}

