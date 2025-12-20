<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Type;

use App\Shared\Infrastructure\Doctrine\Type\IntType;
use App\User\Domain\ValueObject\LegacyUserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class LegacyUserIdType extends Type
{
    public const string NAME = 'legacy_user_id';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
    }
    public function convertToPHPValue($value, AbstractPlatform $platform): ?LegacyUserId
    {
        return $value !== null ? LegacyUserId::fromInt((int) $value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if (!$value instanceof LegacyUserId) {
            throw new \InvalidArgumentException('Expected LegacyUserId');
        }

        return $value->value(); // ok, retourne int
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
