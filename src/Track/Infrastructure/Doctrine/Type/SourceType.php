<?php

declare(strict_types=1);

namespace Track\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use InvalidArgumentException;
use Track\Domain\ValueObject\Source;

final class SourceType extends StringType
{
    private const NAME = 'source_type';

    public function convertToPHPValue($value, AbstractPlatform $platform): Source
    {
        if ($value instanceof Source) {
            return $value;
        }

        try {
            return Source::from($value);
        } catch (InvalidArgumentException) {
            throw new ConversionException();
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof Source) {
            return $value->value;
        }

        try {
            return Source::from($value)->value;
        } catch (InvalidArgumentException) {
            throw new ConversionException();
        }
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
