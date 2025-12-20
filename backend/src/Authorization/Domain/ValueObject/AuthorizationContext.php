<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authorization\Domain\ValueObject;

use App\User\Domain\ValueObject\LegacyUserId;
use App\User\Domain\ValueObject\Roles;

final readonly class AuthorizationContext
{
    /**
     * @param LegacyUserId $userId
     * @param Roles $roles
     * @param Resource $resource
     * @param Action $action
     * @param array<mixed>|null $data
     */
    public function __construct(
        public LegacyUserId $userId,
        public Roles $roles,
        public Resource $resource,
        public Action $action,
        public ?array $data = null
    ) {
    }
}
