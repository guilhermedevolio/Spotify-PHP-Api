<?php
require_once './Services/CurlService.php';
require_once './Contracts/SpotifyServiceContract.php';

class SpotifyService implements SpotifyServiceContract {
    private $config;
    private $api_account_url = "https://accounts.spotify.com";
    private $api_url = "https://api.spotify.com";
    private CurlService $ch;

    public function __set($name, $value) {
        if(empty($this->$name) || is_null($this->$name)) {
            $this->$name = $value;
        }
    }

    public function __construct()
    {
        $this->ch = new CurlService();
        $this->config = require_once './config.php';
        $this->loadConfig();
    }

    private function loadConfig() {
        foreach ($this->config as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getAuthUrl() {
        $scopes = [
            'user-read-private', 
            'user-read-email',
            'ugc-image-upload',
            'user-read-playback-state',
            'user-modify-playback-state'
        ];

        $params = [
            'client_id' => $this->client_id,
            'response_type' => 'code',
            'redirect_uri' => $this->callback_url,
            'scope' => implode(' ', $scopes)
        ];

        return $this->api_account_url . "/authorize?" . http_build_query($params);
    }

    public function getAuthorizationToken(string $code): array
    {
        $url = $this->api_account_url . "/api/token";

        $response = $this->ch->execute($url, 'POST', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->callback_url
        ], [
            'Content-type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($this->client_id . ':' . $this->client_secret)
        ]);

        return json_decode($response, true);
    }

    public function getUserProfile(string $token): array
    {
        $url = $this->api_url . "/v1/me";

        $response = $this->ch->execute($url, 'GET', [], [
            'Content-type: application/json',
            'Authorization: Bearer ' . $token
        ]);

        return json_decode($response, true);
    }

    public function getCurrentMusicListen(string $token): array
    {
        $url = $this->api_url . "/v1/me/player/currently-playing";

        $response = $this->ch->execute($url, 'GET', [], [
            'Content-type: application/json',
            'Authorization: Bearer ' . $token
        ]);

        return json_decode($response, true);
    }

  
}