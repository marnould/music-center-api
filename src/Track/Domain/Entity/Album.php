<?php

namespace Track\Domain\Entity;

use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Album
{
    private readonly UuidInterface $id;
    private readonly CarbonImmutable $createdDate;

    /* @var Track[] */
    private Collection $tracks;

    public function __construct(private string $title, private Artist $artist)
    {
        $this->id = Uuid::uuid4();
        $this->createdDate = CarbonImmutable::now();

        $this->tracks = new ArrayCollection();
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getArtist(): Artist
    {
        return $this->artist;
    }
}
