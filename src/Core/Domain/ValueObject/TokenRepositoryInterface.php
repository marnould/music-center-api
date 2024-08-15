<?php

declare(strict_types=1);

namespace Core\Domain\ValueObject;

use Core\Domain\Entity\Token;

interface TokenRepositoryInterface
{
    public function findOneOrNullBySource(Source $tokenSource): ?Token;

    public function save(Token $token): void;
}
