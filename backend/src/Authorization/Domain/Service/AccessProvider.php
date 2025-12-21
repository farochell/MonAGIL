<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authorization\Domain\Service;

use App\Authorization\Domain\ValueObject\Action;
use App\Authorization\Domain\ValueObject\AuthorizationContext;
use App\Authorization\Domain\ValueObject\Resource;
use App\User\Domain\Service\UserFinder;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Role;

class AccessProvider
{
    public function __construct(
        private UserFinder $userFinder,
    ) {}

    public function check(AuthorizationContext $authorizationContext): bool
    {
        return match ($authorizationContext->resource) {
            Resource::User => match ($authorizationContext->action) {
                Action::UpdatePassword => $this->isCurrentUser($authorizationContext),
                Action::Delete => $this->checkIsManager($authorizationContext),
            },
            Resource::ServiceType => match ($authorizationContext->action) {
                Action::Read => true,
                Action::Delete,
                Action::Create => $this->checkIsAdmin($authorizationContext),
            }
        };
    }

    private function checkIsManager(AuthorizationContext $authorizationContext): bool
    {
        return $authorizationContext->data['managerId'] === $authorizationContext->userId->value();
    }

    private function checkIsAdmin(AuthorizationContext $authorizationContext): bool
    {
        return $authorizationContext->roles->has(Role::admin);
    }

    public function isCurrentUser(AuthorizationContext $authorizationContext): bool
    {
        $user = $this->userFinder->getByEmail(
            Email::fromString($authorizationContext->data['email'])
        );
        return $user->userId === $authorizationContext->userId->value();
    }

}
