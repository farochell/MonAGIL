<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  defi-fullstack-app
 */

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Type;

use App\User\Domain\ValueObject\Roles;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use InvalidArgumentException;

class RolesType extends JsonType
{
    public const string NAME = 'roles';


    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getClobTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Roles
    {
        if (empty($value)) {
            return new Roles([]);
        }

        $decoded = json_decode($value, true);
        if (!is_array($decoded)) {
            throw new InvalidArgumentException('Invalid roles data, expected JSON array.');
        }

        return Roles::fromStrings($decoded);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (!$value instanceof Roles) {
            throw new InvalidArgumentException('Expected instance of Roles.');
        }

        return json_encode($value->toStrings());
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
