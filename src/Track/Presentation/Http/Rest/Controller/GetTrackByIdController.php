<?php

namespace Track\Presentation\Http\Rest\Controller;

use Core\Domain\Bus\Query\QueryBusInterface;
use Ramsey\Uuid\Uuid;
use Track\Application\Query\GetTrackQuery;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetTrackByIdController
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    public function __invoke(string $trackId): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->queryBus->ask(
                new GetTrackQuery(Uuid::fromString($trackId)
                )
            )
        );
    }
}
