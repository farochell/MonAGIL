<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  mon-agil
 */

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Type;

use App\Shared\Infrastructure\Doctrine\Type\StringType;
use App\User\Domain\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EmailType extends StringType
{
    public const string TYPE = 'email';

    #[\Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): Email
    {
        return Email::fromString((string) $value);
    }
}
