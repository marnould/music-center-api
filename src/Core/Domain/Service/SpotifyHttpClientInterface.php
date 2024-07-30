<?php

namespace Core\Domain\Service;

interface SpotifyHttpClientInterface
{
    public function getTrack(string $trackId): string;

    public function getPlaylist(string $playlistId): string;
}