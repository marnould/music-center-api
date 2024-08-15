<?php

namespace Track\Application\Query;

use Core\Domain\Bus\Query\QueryInterface;

readonly class GetAllTracksQuery implements QueryInterface
{
    public function __construct()
    {
    }
}
