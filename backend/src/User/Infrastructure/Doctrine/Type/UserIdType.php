<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  mon-agil
 */

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Type;

use App\User\Domain\ValueObject\UserId;
use App\Shared\Infrastructure\Doctrine\Type\UuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class UserIdType extends UuidType
{
    public const string TYPE = 'user_id';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL([
            'length' => 16,
            'fixed' => true,
        ]);
    }

    #[\Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserId
    {
        if ($value === null) {
            return null;
        }

        if (is_resource($value)) {
            $value = stream_get_contents($value);
        }

        if (!is_string($value)) {
            throw new \InvalidArgumentException(sprintf(
                'UserIdType expects binary string, %s given',
                gettype($value)
            ));
        }

        if (strlen($value) !== 16) {
            throw new \InvalidArgumentException(
                'Invalid binary UUID length, expected 16 bytes'
            );
        }

        $hex = bin2hex($value);
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($hex, 4));

        return UserId::fromString($uuid);
    }




    public function getName(): string
    {
        return self::TYPE;
    }
}
