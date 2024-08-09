<?php

namespace Track\Application\Query;

use Core\Domain\Bus\Query\QueryInterface;
use Ramsey\Uuid\UuidInterface;

readonly class GetTrackQuery implements QueryInterface
{
    public function __construct(private UuidInterface $trackId)
    {
    }

    public function getTrackId(): UuidInterface
    {
        return $this->trackId;
    }
}
