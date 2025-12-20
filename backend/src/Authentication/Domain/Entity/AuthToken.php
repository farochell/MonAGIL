<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authentication\Domain\Entity;

use DateTimeImmutable;

final class AuthToken {
    public function __construct(
        public string $token,
        public DateTimeImmutable $expiresAt
    ){}

    public static function create(
        string $token,
        DateTimeImmutable $expiresAt
    ): self
    {
        return new self($token, $expiresAt);
    }
}
