<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Type;

use App\Shared\Infrastructure\Doctrine\Type\StringType;
use App\User\Domain\ValueObject\MangoUserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class MangoUserIdType extends StringType
{
    public const string TYPE = 'mango_user_id';

    public function getName(): string
    {
        return self::TYPE;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?MangoUserId
    {
        if ($value === null) {
            return null;
        }

        return MangoUserId::fromString((string) $value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof MangoUserId) {
            throw new \InvalidArgumentException('Expected MangoUserId.');
        }

        return $value->toString();
    }
}
