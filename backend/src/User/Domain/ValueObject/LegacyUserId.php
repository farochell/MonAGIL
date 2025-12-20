<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\IntegerValue;

class LegacyUserId extends IntegerValue {
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
