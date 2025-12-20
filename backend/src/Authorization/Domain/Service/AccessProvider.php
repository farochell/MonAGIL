<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authorization\Domain\Service;

use App\Authorization\Domain\ValueObject\AuthorizationContext;
use App\User\Domain\Service\UserFinder;

class AccessProvider
{
    public function __construct(
        private UserFinder $userFinder,
    ) {}

    public function check(AuthorizationContext $authorizationContext): bool
    {

    }
}
