<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use App\Shared\Domain\Collection;
use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\map;

class Roles extends Collection {
    protected function type(): string
    {
        return Role::class;
    }

    public function has(Role $role): bool
    {
        $array =  filter(
            static fn (Role $item) => $item === $role,
            $this->items()
        );
        if (count($array) === 0) {
            return false;
        }
        return true;
    }

    public function toStrings(): array
    {
        return map(
            fn(Role $role) => $role->value,
            $this->items()
        );
    }

    public static function fromStrings(array $values): self
    {
        $roles = map(
            fn(string $value) => Role::fromString($value),
            $values
        );
        return new self($roles);
    }

    public static function fromArray(array $roles): self
    {
        $roleObjects = map(
            fn(string $role): Role => Role::fromString($role),
            $roles
        );

        return new self($roleObjects);
    }

    public function toArray(): array
    {
        return map(
            fn(Role $role) => $role->value,
            $this->items()
        );
    }
}
