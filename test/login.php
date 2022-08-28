<?php

require_once './../vendor/autoload.php';

$config = require('config.php');

$googleLogin = new \Ngekoding\GoogleLogin\GoogleLogin(
    $config['client_id'],
    $config['client_secret'],
    $config['redirect_uri']
);

try {
    $googleLogin->auth();
    
    header('Content-Type: application/json');
    echo json_encode($googleLogin->user());
} catch (\Exception $e) {
    echo 'Error: '.$e->getMessage();
}
