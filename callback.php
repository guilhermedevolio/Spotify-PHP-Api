<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once './Services/SpotifyService.php';

$code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRIPPED);
if(!$code) {
    exit(json_encode([
        'status' => 'erro',
        'mensagem' => 'O código de autorização não foi informado'
    ], JSON_UNESCAPED_UNICODE));
}

$ss = new SpotifyService();
$response = $ss->getAuthorizationToken($code);

if(!$response['access_token'] || empty($response['access_token'])) {
    exit(header('Location: profile.php?erro=1'));
}


$_SESSION['auth'] = true;
$_SESSION['user_token'] = $response['access_token'];
$_SESSION['refresh_token'] = $response['refresh_token'];

header('Location: profile.php');
