<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authentication\Domain\Service;

use App\Authentication\Domain\ValueObject\UserIdentity;

interface AccessTokenGenerator
{
    public function generate(
        UserIdentity $userIdentity,
        int $expiresIn = 3600,
    ): string;
}
