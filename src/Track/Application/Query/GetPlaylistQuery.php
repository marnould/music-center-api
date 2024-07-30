<?php

namespace Track\Application\Query;

use Core\Domain\Bus\Query\QueryInterface;

readonly class GetPlaylistQuery implements QueryInterface
{
    public function __construct(private string $playlistId)
    {
    }

    public function getPlaylistId(): string
    {
        return $this->playlistId;
    }
}