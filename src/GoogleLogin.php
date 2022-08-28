<?php

namespace Ngekoding\GoogleLogin;

class GoogleLogin
{
    private $client;
    private $user;

    /**
     * Construct the Google Login
     * 
     * @param string $clientId
     * @param string $clientSecret
     * @param string $redirectUri
     */
    public function __construct($clientId, $clientSecret, $redirectUri)
    {
        $this->client = new \Google\Client([
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'scopes' => [
                'email',
                'profile'
            ]
        ]);
    }

    /**
     * Get auth URL for Google Login
     * 
     * @return string
     */
    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Authenticate code from Google OAuth Flow
     * 
     * @return void 
     */
    public function validate()
    {
        if (empty($_GET['code'])) {
            throw new \Exception('Can\'t found `code` query paramater.');
        }

        $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);

        if (isset($token['error'])) {
            throw new \Exception($token['error']);
        }
        
        $this->client->setAccessToken($token['access_token']);

        // Get profile info
        $googleOAuth = new \Google\Service\Oauth2($this->client);
        $this->user = $googleOAuth->userinfo->get();
    }

    /**
     * Run the authentication
     * 
     * @return void
     */
    public function auth()
    {
        // Do nothing when the user is already authenticated
        if (!empty($this->user)) return;

        try {
            $this->validate();
        } catch (\Exception $e) {
            header('location: ' . $this->getAuthUrl());
            exit;
        }
    }

    /**
     * Get authenticated user
     * 
     * @return \Google\Service\Oauth2\Userinfo
     */
    public function user()
    {
        return $this->user;
    }
}
