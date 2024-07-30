<?php

namespace Core\Domain\Bus\Query;

interface QueryBusInterface
{
    public function ask(QueryInterface $query);
}
