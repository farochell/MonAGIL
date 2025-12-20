<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authentication\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class SecuritySecret extends StringValueObject
{
    public function equals(SecuritySecret $securitySecret): bool
    {
        return $this->value() === $securitySecret->value();
    }
}
