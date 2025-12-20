<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Uuid;

class UserId extends Uuid {
    public function toString(): string
    {
        return $this->value;
    }
}
