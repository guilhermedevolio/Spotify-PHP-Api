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
    <style>
        .progress-bar {
            transition: 0.3s ease-in-out;
        }
    </style>
    <body>
        <div class="container d-flex justify-content-center p-5 flex-column align-items-center">
            <div class="actual-music d-flex justify-content-between align-items-center" style="display: none;">
                <div class="left">
                    <img id="img-cover" class="rounded" style="margin-right: 30px; border-radius: 8px"></img>
                </div>
                <div class="right">
                    <h2 id="music-name"></h2>
                    <div class="timer d-flex justify-content-center flex-row text-center">
                        <h2 id="progress-actual" class="text-center"></h2> <h2 style="margin-left: 10px; margin-right: 10px;">/</h2> <h2 id="music_length"></h2>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="180879"></div>
                    </div>
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

                        const music_name = $('#music-name').html();
                        const music_length = $('#music_length').html();
                        const music_progress = response.content.actual_progress/response.content.music_duration * 100;
                        
                        $('.progress-bar').css('width', music_progress + '%');
                        
                        if(music_name != response.content.music_name) {
                            $('#music-name').html(response.content.music_name);
                        }

                        if(music_length != response.content.total_music_progress) {
                            $('#music_length').html(response.content.total_music_progress);
                        }
                       
                        $('#progress-actual').html(response.content.progress_to_seconds);
                        $('#img-cover').attr('src', response.content.cover);

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
