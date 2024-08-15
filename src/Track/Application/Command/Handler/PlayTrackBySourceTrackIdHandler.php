<?php

namespace Track\Application\Command\Handler;

use Core\Domain\Bus\Command\CommandHandlerInterface;
use Core\Domain\Service\SpotifyHttpClientInterface;
use Track\Application\Command\PlayTrackBySourceTrackIdCommand;
use Track\Domain\Repository\TrackRepositoryInterface;

readonly class PlayTrackBySourceTrackIdHandler implements CommandHandlerInterface
{
    public function __construct(
        private TrackRepositoryInterface $trackRepository,
        private SpotifyHttpClientInterface $spotifyHttpClient
    )
    {
    }

    public function __invoke(PlayTrackBySourceTrackIdCommand $command): string
    {
        return $this->spotifyHttpClient->playTrack(
            $this->trackRepository->findOneById($command->getTrackId())
        );
    }
}
