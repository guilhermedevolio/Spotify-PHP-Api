<?php

interface SpotifyServiceContract {
    public function getAuthUrl();
    public function getAuthorizationToken(string $code);
    public function getUserProfile(string $code);
    public function getCurrentMusicListen(string $code);
}