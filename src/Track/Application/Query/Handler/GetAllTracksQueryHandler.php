<?php

namespace Track\Application\Query\Handler;

use Core\Domain\Bus\Query\QueryHandlerInterface;
use Track\Application\Query\GetAllTracksQuery;
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
