<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authentication\Domain\Service;

use App\Authentication\Domain\ValueObject\AccessToken;

interface AccessTokenDecoder
{
    public function decode(
        string $token
    ): AccessToken;
}
