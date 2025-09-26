<?php

namespace Config;

use CodeIgniter\Shield\Config\Auth as ShieldAuth;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

class Auth extends ShieldAuth
{
    /**
     * Social providers configuration.
     */
    public array $socialProviders = [];

    /**
     * Specifies the class to use for various authentication actions.
     * Disable actions by setting them to null since we are handling OAuth manually.
     *
     * @var array<string, class-string|null>
     */
    public array $actions = [
        'login'    => null, // Disabled for GitHub OAuth
        'register' => null, // Disabled for GitHub OAuth
        'social'   => null, // Disabled; handled manually in controller
    ];

    /**
     * @var array<string, string>
     */
    public array $authenticators = [
        'session' => Session::class,
    ];

    /**
     * Default authenticator
     *
     * @var string
     */
    public string $defaultAuthenticator = 'session';

    /**
     * Session configuration
     *
     * @var array<string, mixed>
     */
    public array $sessionConfig = [
        'field'             => 'user',
        'allowRemembering'  => true,
        'rememberCookieName'=> 'remember',
        'rememberLength'    => 30 * 24 * 60 * 60, // 30 days
    ];

    /**
     * Registration settings
     *
     * @var bool
     */
    public bool $allowRegistration = true;

    /**
     * Valid login fields
     *
     * @var array<int, string>
     */
    public array $validFields = ['email'];

    /**
     * Username field
     *
     * @var string
     */
    public string $usernameField = 'email';

    /**
     * Remembering
     *
     * @var bool
     */
    public bool $allowRemembering = true;

    /**
     * Minimum password length
     *
     * @var int
     */
    public int $minimumPasswordLength = 8;

    /**
     * Require activation
     *
     * @var bool
     */
    public bool $requireActivation = false;

    public function __construct()
    {
        parent::__construct();

        // Load GitHub OAuth credentials from .env
        $this->socialProviders['github'] = [
            'clientId'     => env('GITHUB_CLIENT_ID'),
            'clientSecret' => env('GITHUB_CLIENT_SECRET'),
            'redirectUri'  => 'http://localhost:8080/auth/callback/github',
            'scopes'       => ['user:email'],
        ];
    }

    
}
