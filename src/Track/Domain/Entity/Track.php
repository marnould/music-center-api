<?php

namespace Track\Domain\Entity;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\UuidInterface;
use Track\Domain\ValueObject\Source;

class Track
{
    private readonly UuidInterface $id;
    private readonly CarbonImmutable $createdDate;

    public function __construct(
        private string $title,
        private Artist $artist,
        private Album $album,
        private Source $source,
        private string $sourceTrackId
    ) {
        $this->createdDate = CarbonImmutable::now();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCreatedDate(): CarbonImmutable
    {
        return $this->createdDate;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getArtist(): Artist
    {
        return $this->artist;
    }

    public function getAlbum(): Album
    {
        return $this->album;
    }

    public function getSource(): Source
    {
        return $this->source;
    }

    public function getSourceTrackId(): string
    {
        return $this->sourceTrackId;
    }
}
