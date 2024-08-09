<?php

namespace Track\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Ramsey\Uuid\UuidInterface;
use Track\Domain\Entity\Track;
use Track\Domain\Repository\TrackRepositoryInterface;

class TrackRepository implements TrackRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function findOneById(UuidInterface $trackId): Track
    {
        $track = $this->em->createQueryBuilder()
            ->select('t')
            ->from(Track::class, 't')
            ->where('t.id = :trackId')
            ->setParameter('trackId', $trackId->toString())
            ->getQuery()
            ->getOneOrNullResult();

        if (!$track) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(Track::class, [$trackId->toString()]);
        }

        return $track;
    }
}
