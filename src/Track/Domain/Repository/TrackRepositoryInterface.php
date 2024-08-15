<?php

namespace Track\Domain\Repository;

use Ramsey\Uuid\UuidInterface;
use Track\Domain\Entity\Track;

interface TrackRepositoryInterface
{
    public function findOneById(UuidInterface $trackId): Track;

    public function findAll(): array;
}
