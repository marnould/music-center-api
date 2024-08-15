<?php

namespace Track\Presentation\Http\Rest\Controller;

use Core\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Track\Application\Query\GetTrackQuery;

class GetPlaylistController
{
    public const TEST_PLAYLIST_URI_TEST = '2FiuIr7W9o2cyeiwcqpn91';

    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    public function __invoke(): JsonResponse
    {
        return JsonResponse::fromJsonString($this->queryBus->ask(new GetTrackQuery(self::TEST_PLAYLIST_URI_TEST)));
    }
}
