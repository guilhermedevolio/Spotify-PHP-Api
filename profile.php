<?php
session_start();

if(!isset($_SESSION['auth'])) {
    return header('Location: index.php');
}

require_once './Services/SpotifyService.php';
require_once './Transformers/SpotifyTransformer.php';

$ss = new SpotifyService();

?>

<html>
    <head>
        <title>Profile</title>
        <link rel="stylesheet" href="https://bootswatch.com/5/vapor/bootstrap.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <div class="container d-flex justify-content-center p-5 flex-column align-items-center">
            <div class="actual-music">
                <h2 id="music-name"></h2>
                <div class="timer d-flex justify-content-center flex-row text-center">
                    <h2 id="progress-actual"></h2> <h2 style="margin-left: 10px; margin-right: 10px;">/</h2> <h2 id="music_length"></h2>
                </div>
            </div>
        </div>
    </body>
    <script>

        function getCurrentMusic() {
            $.ajax({
                url: './Webservices/api.php',
                method: 'POST',
                data: {
                    action: 'actualMusic'
                },
                success: function(response) {
                    if(response.status === "sucesso") {
                        $('#music-name').html(response.content.music_name);
                        $('#progress-actual').html(response.content.progress_to_seconds);
                        $('#music_length').html(response.content.total_music_progress);
                    }
                }
            })
        }

        $(function() {
            getCurrentMusic();
            setInterval(() => {
                getCurrentMusic();
            }, 1000);
        })
    </script>
</html>
