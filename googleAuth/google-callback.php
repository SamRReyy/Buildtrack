<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Google_Service_Oauth2;

session_start();

$dotenvn = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenvn->load();

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT']);

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        try {
            $oauth2 = new Google_Service_Oauth2($client);
            $userInfo = $oauth2->userinfo->get();

            $_SESSION['user_type'] = 'google';
            $_SESSION['user_name'] = $userInfo->name;
            $_SESSION['user_email'] = $userInfo->email;
            $_SESSION['user_image'] = $userInfo->picture;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Failed to fetch user information: ' . $e->getMessage();
            header('Location: login.php');
            exit();
        }

        $_SESSION['success'] = 'Login With Google!';
        header('Location: admin/index.php');
        exit();
    } else {
        $_SESSION['error'] = 'Login failed!';
        header('Location: login.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Invalid Login!';
    header('Location: login.php');
    exit();
}