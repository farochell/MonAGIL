<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authentication\Domain\ValueObject;

readonly class AccessToken
{
    /**
     * @param array<string> $roles
     */
    public function __construct(
        public string $content,
        public int $id,
        public string $username,
        public array $roles,
        public int $createdAt,
        public int $expiresAt,
    ) {}
}
