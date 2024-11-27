<?php
session_start();
require_once '../../vendor/autoload.php'; // Ensure you have installed the Google API client library via Composer
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_SECRET_CLIENT']);
$client->setRedirectUri('http://localhost/Proyecto-Final-Back/views/login_google.php');
$client->addScope('email');
$client->addScope('profile');


if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if ($token) {
        $_SESSION['access_token'] = $token;
        $client->setAccessToken($token);
        $user = $client->userinfo();
        if ($user->getAccessToken()) {
            $userData = $user->getDecodedResponse();
            $_SESSION['user'] = $userData;
            header('Location: ./alumno-perfil.php'); 
            exit();
        }
    }
}

if ($client->getAccessToken()) {
    $user = $client->userinfo();
    if ($user->getAccessToken()) {
        $userData = $user->getDecodedResponse();
        $_SESSION['user'] = $userData;
        header('Location: ./alumno-perfil.php');
        exit();
    }
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit();
}
?>
