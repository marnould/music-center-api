<?php

namespace Core\Infrastructure\HttpClient;

use Core\Domain\Entity\Token;
use Core\Domain\Service\SpotifyHttpClientInterface;
use Core\Domain\ValueObject\Source;
use Core\Domain\ValueObject\TokenRepositoryInterface;
use Ramsey\Uuid\Nonstandard\Uuid;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Track\Domain\Entity\Track;

class SpotifyHttpClient implements SpotifyHttpClientInterface
{
    public const SPOTIFY_BASE_URL = 'https://api.spotify.com/v1';
    public const REDIRECT_URI = 'http://127.0.0.1:8000';
    public const DEV_SPOTIFY_AUTH_CODE_DEV = 'AQCue7o1jrX6LiX1VheawgP-rNQg68nKdxAroSGop5jKx4X2q_50ykFvCgvCUIlN0pyhH6OvsK2cHAQFngtMK4BvVuVc0Df9_aq5OrrcNQzl5iQHutaGnNSsApWr6N0MD1h8MB4-6_7Cr8HfyQvBKcsba5bK0PPsYQavHOc5ojo-OgZYy8PeI488YWNXrq4q87IKgWAryfrKd2ye-vTAb_IeByLM3BYYDjqt5CezKJzSiIcmkvaumB5UWjW6OhzWSielrCJfIecKwLLSUST7BlhHkSiMuU9Wee8tcUNKRbgZ8qGg83YcHMZ8-vZKjcNOQFAeL318JSIVv_z8aKFXyyzQV6StfrC3OHK3UdhHmH9dBjUbAOOZKY8n3loKJZcI-LAoaMMg6oNYXwTIFwAT-hR_BLkzb717Rursm-s28mHSPP4rijqaMmdSnoQsUxPz6TUelaeni8HUxTRxX_ihEI5Fy252ltC-3pYdibSm8EvZGLUCuA4';

    private readonly HttpClientInterface $client;

    public function __construct(
        private readonly string $spotifyClientId,
        private readonly string $spotifyClientSecret,
        private readonly TokenRepositoryInterface $tokenRepository
    ) {
        $this->client = HttpClient::create();
    }

    /** @TODO Need to be passed in front in order to ask the user grants */
    private function authorize()
    {
        $responseType = 'code';
        $scope = 'user-read-playback-state user-modify-playback-state user-read-currently-playing app-remote-control streaming playlist-read-private playlist-modify-private playlist-modify-public user-read-playback-position user-library-read user-read-private';
        $state = Uuid::uuid4()->toString();

        $queryString = sprintf(
            'response_type=%s&client_id=%s&scope=%s&redirect_uri=%s&state=%s&show_dialog=%s',
            $responseType,
            $this->spotifyClientId,
            $scope,
            self::REDIRECT_URI,
            $state,
            false
        );

        $response = $this->client->request(
            'GET',
            sprintf('https://accounts.spotify.com/authorize?%s', $queryString)
        );

        return $response->getContent();
    }

    public function getValidToken(): Token
    {
        $existingAccessToken = $this->tokenRepository->findOneOrNullBySource(Source::SPOTIFY);

        switch ($existingAccessToken) {
            case null:
                $accessToken = $this->getAccessToken();
                $this->tokenRepository->save($accessToken);

                return $accessToken;

            case $existingAccessToken->getExpireDate()->isPast():
                $refreshToken = $this->getRefreshToken($existingAccessToken);

                $this->tokenRepository->save($refreshToken);

                return $refreshToken;

            case $existingAccessToken->getExpireDate()->isFuture():
            default:
                return $existingAccessToken;
        }
    }

    private function getAccessToken(): Token
    {
        $encodedCredentials = base64_encode(
            sprintf('%s:%s', $this->spotifyClientId, $this->spotifyClientSecret)
        );

        $response = $this->client->request(
            'POST',
            'https://accounts.spotify.com/api/token',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => sprintf('Basic %s', $encodedCredentials),
                ],
                'body' => [
                    'grant_type' => 'authorization_code',
                    'code' => self::DEV_SPOTIFY_AUTH_CODE_DEV,
                    'redirect_uri' => self::REDIRECT_URI,
                ],
            ]
        );

        $responseToken = $response->toArray();

        return Token::create(
            $responseToken['access_token'],
            $responseToken['refresh_token'],
            'spotify',
            $responseToken['expires_in']
        );
    }

    private function getRefreshToken(Token $existingToken): Token
    {
        $encodedCredentials = base64_encode(
            sprintf('%s:%s', $this->spotifyClientId, $this->spotifyClientSecret)
        );

        $response = $this->client->request(
            'POST',
            'https://accounts.spotify.com/api/token',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => sprintf('Basic %s', $encodedCredentials),
                ],
                'body' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $existingToken->getRefreshToken(),
                ],
            ]
        );

        $responseToken = $response->toArray();

        $existingToken->update($responseToken['access_token'], $responseToken['expires_in']);

        return $existingToken;
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getTrack(Track $track): string
    {
        $response = $this->client->request(
            'GET',
            self::SPOTIFY_BASE_URL.'/tracks/'.$track->getSourceTrackId(),
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->getValidToken()->getAccessToken(),
                ],
            ]
        );

        return $response->getContent();
    }

    public function playTrack(Track $track): string
    {
        $response = $this->client->request(
            'PUT',
            self::SPOTIFY_BASE_URL.'/me/player/play',
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->getValidToken()->getAccessToken(),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'uris' => ['spotify:track:'.$track->getSourceTrackId()],
                ],
            ]
        );

        return $response->getContent(false);
    }
}
