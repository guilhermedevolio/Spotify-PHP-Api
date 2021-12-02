<?php
session_start();

require_once './Services/SpotifyService.php';
header('Content-Type: application/json; charset=utf-8');

$ss = new SpotifyService();

$code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRIPPED);

if(!$code) {
    exit(json_encode(['status' => 'erro', 'mensagem' => 'O código de autorização não foi informado'], JSON_UNESCAPED_UNICODE));
}

$response = $ss->getAuthorizationToken($code);

if(!$response['access_token'] || empty($response['access_token'])) {
    header('Location: profile.php?erro=1');
}

$_SESSION['auth'] = true;
$_SESSION['user_token'] = $response['access_token'];
$_SESSION['refresh_token'] = $response['refresh_token'];

header('Location: profile.php');