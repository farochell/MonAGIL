<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  mon-agil
 */

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Type;

use App\Authentication\Domain\ValueObject\HashedPassword;
use App\Shared\Infrastructure\Doctrine\Type\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class HashedPasswordType extends StringType
{
    public const string TYPE = 'hashed_password';

    #[\Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): HashedPassword
    {
        return HashedPassword::fromString((string) $value);
    }
}
