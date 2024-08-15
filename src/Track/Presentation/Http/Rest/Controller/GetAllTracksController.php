<?php

namespace Track\Presentation\Http\Rest\Controller;

use Core\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Track\Application\Query\GetAllTracksQuery;

class GetAllTracksController
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->queryBus->ask(new GetAllTracksQuery()));
    }
}
