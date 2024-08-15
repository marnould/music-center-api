<?php

namespace Track\Application\Command;

use Core\Domain\Bus\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

readonly class PlayTrackBySourceTrackIdCommand implements CommandInterface
{
    public function __construct(private UuidInterface $trackId)
    {
    }

    public function getTrackId(): UuidInterface
    {
        return $this->trackId;
    }
}
