<?php

namespace Track\Application\Query\Handler;

use Core\Domain\Bus\Query\QueryHandlerInterface;
use Core\Domain\Service\SpotifyHttpClientInterface;
use Track\Application\Query\GetAllTracksQuery;
use Track\Application\Query\GetTrackQuery;
use Track\Domain\Repository\TrackRepositoryInterface;

readonly class GetAllTracksQueryHandler implements QueryHandlerInterface
{
    public function __construct(private TrackRepositoryInterface $trackRepository)
    {
    }

    public function __invoke(GetAllTracksQuery $query): array
    {
        return $this->trackRepository->findAll();
    }
}
