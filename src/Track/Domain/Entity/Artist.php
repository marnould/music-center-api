<?php

namespace Track\Domain\Entity;

use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Artist
{
    private readonly UuidInterface $id;
    private readonly CarbonImmutable $createdDate;
    private Collection $tracks;
    private Collection $albums;

    public function __construct(private string $name) {
        $this->id = Uuid::uuid4();
        $this->createdDate = CarbonImmutable::now();

        $this->tracks = new ArrayCollection();
        $this->albums = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCreatedDate(): CarbonImmutable
    {
        return $this->createdDate;
    }

    /** @return Track[] */
    public function getTracks(): array
    {
        return $this->tracks->toArray();
    }

    /** @return Album[] */
    public function getAlbums(): array
    {
        return $this->albums->toArray();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
