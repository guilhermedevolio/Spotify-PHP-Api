<?php
header('Content-type: application/json; charset=UTF-8');
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/Services/CurlService.php';
require $_SERVER['DOCUMENT_ROOT'] . '/Services/SpotifyService.php';
require $_SERVER['DOCUMENT_ROOT'] . '/Transformers/SpotifyTransformer.php';

if(!isset($_POST['action'])) {
    exit(json_encode(['status' => 'erro', 'msg' => 'Please, send a action code']));
}

$ss = new SpotifyService();

switch ($_POST['action']) {
    case 'currentMusic':

        $currentMusic = (new SpotifyTransformer)
            ->handleListenMusic($ss->getCurrentMusicListen($_SESSION['user_token']));

        if(!$currentMusic['music_name']) {
            $retorno['status'] = "erro";
            $retorno['listen'] = false;
            $retorno['content'] = "Nenhuma música tocando no momento";
            break;
        }

        $retorno['status'] = "sucesso";
        $retorno['listen'] = true;
        $retorno['content'] = $currentMusic;

        break;

    default:
        # code...
        break;
}

exit(json_encode($retorno));
