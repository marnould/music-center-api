<?php

namespace Track\Presentation\Http\Rest\Controller;

use Core\Domain\Bus\Command\CommandBusInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Track\Application\Command\PlayTrackBySourceTrackIdCommand;

class PlayTrackBySourceTrackIdController
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    public function __invoke(string $trackId): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->commandBus->publish(
                new PlayTrackBySourceTrackIdCommand(Uuid::fromString($trackId)
                )
            )
        );
    }
}
