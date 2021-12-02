<?php
    require_once './Services/SpotifyService.php';
    $sService = new SpotifyService();
?>

<html>
    <head>
        <title>API Spotify - Guilherme Devólio</title>
        <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.css">
    </head>
    <body>
        <?php
            if(isset($_GET['erro'])) {
                switch ($_GET['erro']) {
                    case '1':
                        $erro = "Ocorreu um erro ao se autenticar com os serviços do spotify, tente novamente";
                        break;
                    
                    default:
                        break;
                }
            }

            if(isset($erro)) {
                echo "<a style='color:red'>{$erro}</a><br>";
            }
        ?>
        <a href="<?php echo $sService->getAuthUrl(); ?>">Entrar com spotify</a>
    </body>
</html>
