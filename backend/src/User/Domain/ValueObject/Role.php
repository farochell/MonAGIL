<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use InvalidArgumentException;

enum Role: string
{
    case propertyManager = 'ROLE_GESTIONNAIRE';
    case artisan = 'ROLE_ARTISAN';
    case admin = 'ROLE_ADMIN';
    case api = 'ROLE_API';

    public static function fromString(string $value): Role {
        return match($value) {
            'ROLE_ADMIN' => self::admin,
            'ROLE_GESTIONNAIRE' => self::propertyManager,
            'ROLE_ARTISAN' => self::artisan,
            'ROLE_API' => self::api,
            default => throw new InvalidArgumentException("Invalid role: $value"),
        };
    }
    public static function fromStringArray(array $values): array
    {
        return array_map(fn(string $value) => self::fromString($value), $values);
    }

    public static function toStringArray(array $roles): array
    {
        return array_map(fn(self $role) => $role->value, $roles);
    }
}
