<?php

namespace Track\Application\Query\Handler;

use Core\Domain\Bus\Query\QueryHandlerInterface;
use Core\Domain\Service\SpotifyHttpClientInterface;
use Track\Application\Query\GetTrackQuery;
use Track\Domain\Repository\TrackRepositoryInterface;

readonly class GetTrackQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private TrackRepositoryInterface $trackRepository,
        private SpotifyHttpClientInterface $spotifyHttpClient
    ) {
    }

    public function __invoke(GetTrackQuery $query): string
    {
        return $this->spotifyHttpClient->getTrack(
            $this->trackRepository->findOneById($query->getTrackId())
        );
    }
}
