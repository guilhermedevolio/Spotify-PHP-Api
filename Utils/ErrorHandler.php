<?php

class ErrorHandler{
    public function getSpotifyErrorFromCode($code): string
    {
        mreturn match ($code) {
            1 => 'Ooops, Ocorre um erro ao validar o código de autenticação',
            default => "Ops, erro desconhecido"
        };
    }
}