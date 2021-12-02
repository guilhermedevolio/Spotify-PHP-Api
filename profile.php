<?php
session_start();

if(!isset($_SESSION['auth'])) {
    return header('Location: index.php');
}

require_once './Services/SpotifyService.php';

$ss = new SpotifyService();

print_r($ss->getCurrentMusicListen($_SESSION['user_token']));
