<?php
    require_once './Services/SpotifyService.php';
    require_once './Utils/ErrorHandler.php';

    $sService = new SpotifyService();
    $eHanler = new ErrorHandler();
    $errorCode = !empty($_GET['erro']) ? htmlspecialchars($_GET['erro']) : false;
?>

<html>
    <head>
        <title>API Spotify - Guilherme Devólio</title>
        <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.css">
    </head>
    <body>
        <?php
            if(isset($errorCode)) {

        ?>
            <h2> <?php echo $eHanler->getSpotifyErrorFromCode($errorCode) ?> </h2>
        <?php } ?>

        <a href="<?php echo $sService->getAuthUrl(); ?>">Entrar com spotify</a>
    </body>
</html>
