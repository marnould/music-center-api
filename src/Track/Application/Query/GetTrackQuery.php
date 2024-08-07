<?php

namespace Track\Application\Query;

use Core\Domain\Bus\Query\QueryInterface;

readonly class GetTrackQuery implements QueryInterface
{
    public function __construct(private string $trackId)
    {
    }

    public function getTrackId(): string
    {
        return $this->trackId;
    }
}