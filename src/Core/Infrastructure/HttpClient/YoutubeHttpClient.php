<?php

namespace Core\Infrastructure\HttpClient;

use Core\Domain\Service\YoutubeHttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class YoutubeHttpClient implements YoutubeHttpClientInterface
{
    public const YOUTUBE_BASE_URL = 'https://api.spotify.com';

    private readonly HttpClientInterface $client;

    public function __construct(private readonly string $youtubeClientId, private readonly string $youtubeClientSecret)
    {
        $this->client = HttpClient::create();
    }

    private function getToken(): string
    {
        return 'to implement';
    }

    public function getTrack(string $trackId): string
    {
        return 'to implement';
    }

    public function getPlaylist(string $playlistId): string
    {
        return 'to implement';
    }
}
