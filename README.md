# Google Login

The easy way to integrate Google Login into PHP application.

## Requirements

- PHP 5.6 or above
- The **OAuth client ID** from Google Cloud Console

## Installation

```sh
composer require ngekoding/google-login
```

## Usage

Just call the `auth` method and you are done!

```php
<?php
// Include the autoload
require_once 'vendor/autoload.php';

// Prepare the configs
$clientId = 'YOUR CLIENT ID';
$clientSecret = 'YOUR CLIENT SECRET';
$redirectUri = 'YOUR REDIRECT URI'; // The URL to this file/endpoint

$googleLogin = new \Ngekoding\GoogleLogin\GoogleLogin($clientId, $clientSecret, $redirectUri);

try {
    $googleLogin->auth();
    
    header('Content-Type: application/json');
    echo json_encode($googleLogin->user());
} catch (\Exception $e) {
    echo 'Error: '.$e->getMessage();
}
```
