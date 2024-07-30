<?php

namespace Core\Infrastructure\HttpClient;

use Core\Domain\Service\SpotifyHttpClientInterface;
use Core\Domain\Service\YoutubeHttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class YoutubeHttpClient implements YoutubeHttpClientInterface
{
    const YOUTUBE_BASE_URL = 'https://api.spotify.com';

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