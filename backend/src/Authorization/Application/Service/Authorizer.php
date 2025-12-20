<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authorization\Application\Service;

use App\Authorization\Domain\Service\AccessProvider;
use App\Authorization\Domain\ValueObject\AuthorizationContext;

final readonly class Authorizer
{
    public function __construct(
        private AccessProvider $accessProvider
    ) {}

    public function authorize(AuthorizationContext $authorizationContext): bool
    {
        return $this->accessProvider->check($authorizationContext);
    }
}
