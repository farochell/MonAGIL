<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authentication\Application\Login;

use App\Shared\Domain\Bus\Query\Query;

class LoginQuery implements Query
{
    public function __construct(
        public string $username,
        public string $password
    ) {
    }
}
