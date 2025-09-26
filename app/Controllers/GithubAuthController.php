<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\Session as SessionAuthenticator;
use CodeIgniter\Shield\Entities\User;
use League\OAuth2\Client\Provider\Github;
use League\OAuth2\Client\Provider\GithubResourceOwner;
use CodeIgniter\Shield\Authentication\Authenticators\Session as SessionAuthenticator;

class GithubAuthController extends BaseController
{
    protected $auth;
    protected $session;

    public function __construct()
    {
        $this->auth = service('auth');
        $this->session = service('session');
    }

    protected function provider(): Github
    {
        $config = config('Auth')->socialProviders['github'];

        if (empty($config['clientId']) || empty($config['clientSecret'])) {
            throw new \RuntimeException('GitHub OAuth credentials are not configured.');
        }

        return new Github([
            'clientId'     => $config['clientId'],
            'clientSecret' => $config['clientSecret'],
            'redirectUri'  => $config['redirectUri'] ?? base_url('auth/callback/github'),
        ]);
    }

    public function redirect()
    {
        try {
            $provider = $this->provider();
            $authUrl = $provider->getAuthorizationUrl([
                'scope' => ['user:email']
            ]);

            // Store state in session to prevent CSRF
            $this->session->set('oauth2state', $provider->getState());

            return redirect()->to($authUrl);
        } catch (\Exception $e) {
            log_message('error', 'GitHub OAuth Redirect Error: ' . $e->getMessage());
            return redirect()->to('/login')
                ->with('error', 'Could not connect to GitHub. Please try again later.');
        }
    }

    public function callback()
    {
        $provider = $this->provider();
        $code = $this->request->getGet('code');
        $state = $this->request->getGet('state');

        // Verify state matches what we stored
        if (empty($state) || ($state !== $this->session->get('oauth2state'))) {
            $this->session->remove('oauth2state');
            return redirect()->to('/login')->with('error', 'Invalid state');
        }

        if (!$code) {
            return redirect()->to('/login')->with('error', 'No authorization code received');
        }

        try {
            // Get access token
            $token = $provider->getAccessToken('authorization_code', ['code' => $code]);

            // Get user details
            /** @var GithubResourceOwner $githubUser */
            $githubUser = $provider->getResourceOwner($token);
            $githubData = $githubUser->toArray();

            $email = $githubUser->getEmail() ?? $githubUser->getNickname() . '@users.noreply.github.com';
            $username = $githubUser->getNickname();
            $name = $githubUser->getName() ?? $username;

            // Get the Shield users provider
            $users = $this->auth->getProvider();

            // Check if user exists
            $existingUser = $users->where('email', $email)->first();

            if ($existingUser) {
                // Log in existing user
                $this->auth->login($existingUser);
                $user = $existingUser;
            } else {
                // Create new Shield user
                $user = new User([
                    'username' => $username,
                    'email'    => $email,
                    'password' => bin2hex(random_bytes(32)),
                    'name'     => $name,
                    'active'   => 1,
                ]);

                $users->save($user);

                // Assign to default group if not already
                $user = $users->findById($users->getInsertID());
                if (!$user->inGroup('user')) {
                    $user->addGroup('user');
                }

                $users->save($user);

                // Log in the new user
                $this->auth->login($user);
            }

            // Clear the state
            $this->session->remove('oauth2state');

            // Regenerate session ID
            $this->session->regenerate(true);

            // Redirect to dashboard or stored URL
            $redirect = $this->session->getTempdata('redirect_after_login') ?? '/dashboard';
            $this->session->removeTempdata('redirect_after_login');

            $this->session->setFlashdata('message', 'Successfully logged in with GitHub!');

            return redirect()->to($redirect);

        } catch (\Exception $e) {
            log_message('error', 'GitHub OAuth Error: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());

            if (session_status() === PHP_SESSION_ACTIVE) {
                $this->session->remove('oauth2state');
                $this->session->remove('user');
                $this->session->remove('logged_in');
                $this->session->destroy();
            }

            $errorMessage = ENVIRONMENT === 'development'
                ? 'GitHub Authentication Error: ' . $e->getMessage()
                : 'Failed to authenticate with GitHub. Please try again.';

            return redirect()->to('/login')->with('error', $errorMessage);
        }
    }
}
