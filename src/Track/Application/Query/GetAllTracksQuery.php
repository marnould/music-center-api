<?php

namespace Track\Application\Query;

use Core\Domain\Bus\Query\QueryInterface;
use Ramsey\Uuid\UuidInterface;

readonly class GetAllTracksQuery implements QueryInterface
{
    public function __construct()
    {
    }
}
