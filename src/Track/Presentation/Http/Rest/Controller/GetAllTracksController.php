<?php

namespace Track\Presentation\Http\Rest\Controller;

use Core\Domain\Bus\Query\QueryBusInterface;
use Track\Application\Query\GetAllTracksQuery;
use Symfony\Component\HttpFoundation\JsonResponse;

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
