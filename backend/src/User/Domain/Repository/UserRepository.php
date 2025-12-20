<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\User;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\UserId;

interface UserRepository {
    public function findByUserId(UserId $userId): ?User;

    public function save(User $user): void;

    public function findByEmail(Email $email): ?User;

    public function findByToken(string $token): ?User;
}
