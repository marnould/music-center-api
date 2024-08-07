<?php

namespace Core\Infrastructure\HttpClient;

use Core\Domain\Service\SpotifyHttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpotifyHttpClient implements SpotifyHttpClientInterface
{
    const SPOTIFY_BASE_URL = 'https://api.spotify.com';

    private readonly HttpClientInterface $client;

    public function __construct(private readonly string $spotifyClientId, private readonly string $spotifyClientSecret)
    {
        $this->client = HttpClient::create();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function getToken(): string
    {
        $response = $this->client->request(
            'POST',
            'https://accounts.spotify.com/api/token',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->spotifyClientId,
                    'client_secret' => $this->spotifyClientSecret
                ],
            ]
        );

        return $response->toArray()['access_token'];
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getTrack(string $trackId): string
    {
        $response = $this->client->request(
            'GET',
            self::SPOTIFY_BASE_URL . '/v1/tracks/' . $trackId,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getToken(),
                ]
            ]
        );

        return $response->getContent();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface|DecodingExceptionInterface
     */
    public function getPlaylist(string $playlistId): string
    {
        $response = $this->client->request(
            'GET',
            self::SPOTIFY_BASE_URL . '/v1/playlists/' . $playlistId,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getToken(),
                ]
            ]
        );

        return $response->getContent();
    }
}