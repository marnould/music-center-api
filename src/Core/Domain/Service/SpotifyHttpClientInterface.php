<?php

namespace Core\Domain\Service;

use Track\Domain\Entity\Track;

interface SpotifyHttpClientInterface
{
    public function getTrack(Track $track): string;

    public function getPlaylist(string $playlistId): string;

    public function playTrack(Track $track): string;
}
