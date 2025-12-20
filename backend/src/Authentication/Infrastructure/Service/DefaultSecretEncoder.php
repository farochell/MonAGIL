<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authentication\Infrastructure\Service;

use App\Authentication\Domain\Service\SecretEncoder;
use App\Authentication\Domain\ValueObject\HashedPassword;
use App\Authentication\Domain\ValueObject\Password;

class DefaultSecretEncoder implements SecretEncoder
{
    public function encode(Password $plainText): HashedPassword {
        $hashedPassword = password_hash($plainText->value(), PASSWORD_ARGON2ID);
        return HashedPassword::fromString($hashedPassword);
    }
}
