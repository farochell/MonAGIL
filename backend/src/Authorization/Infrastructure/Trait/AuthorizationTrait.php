<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authorization\Infrastructure\Trait;

use App\Shared\Infrastructure\Context\InMemoryContextService;
use App\User\Domain\ValueObject\LegacyUserId;
use App\User\Domain\ValueObject\Roles;
use App\Authorization\Domain\ValueObject\Action;
use App\Authorization\Domain\ValueObject\AuthorizationContext;
use App\Authorization\Domain\ValueObject\Resource;

trait AuthorizationTrait
{
    /**
     * @param Resource $resource
     * @param Action $action
     * @param array<mixed>|null $data
     */
    private function authorize(Resource $resource, Action $action, ?array $data): void
    {

    }

    /**
     * @param Resource $resource
     * @param Action $action
     * @param array<mixed>|null $data
     * @return AuthorizationContext
     */
    private function getAuthorizationContext(Resource $resource, Action $action, ?array $data): AuthorizationContext
    {
        $inMemoryContextService = new InMemoryContextService();
        return new AuthorizationContext(
            LegacyUserId::fromInt($inMemoryContextService->get('user')->id),
            Roles::fromArray($inMemoryContextService->get('user')?->roles),
            $resource,
            $action,
            $data
        );
    }
}
