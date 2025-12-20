<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authentication\Domain\ValueObject;

class UserIdentity {
    public function __construct(
        public int $userId,
        public string $username,
        public array $roles,
    ) {}
}
