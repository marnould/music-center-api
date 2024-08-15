<?php

namespace Track\Application\Query\Handler;

use Core\Domain\Bus\Query\QueryHandlerInterface;
use Core\Domain\Service\SpotifyHttpClientInterface;
use Track\Application\Query\GetPlaylistQuery;

readonly class GetPlaylistQueryHandler implements QueryHandlerInterface
{
    public function __construct(private SpotifyHttpClientInterface $spotifyHttpClient)
    {
    }

    public function __invoke(GetPlaylistQuery $query): string
    {
        return $this->spotifyHttpClient->getPlaylist($query->getPlaylistId());
    }
}
