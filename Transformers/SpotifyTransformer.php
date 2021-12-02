<?php

class SpotifyTransformer {
    public function handleListenMusic(array $payload) {

        $progress_to_seconds = $this->getMsToSeconds($payload['progress_ms']);
        $total_music_progress = $this->getMsToSeconds($payload['item']['duration_ms']);

        return [
            'music_name' => $payload['item']['name'],
            'music_duration' => $payload['item']['duration_ms'],
            'music_spotify_link' => $payload['item']['external_urls']['spotify'],
            'is_playing' => $payload['is_playing'],
            'actual_progress' => $payload['progress_ms'],
            'progress_to_seconds' => $progress_to_seconds,
            'total_music_progress' => $total_music_progress
        ];
    }

    public function getMsToSeconds($value) {
        return date("i:s", $value / 1000);
    }
}