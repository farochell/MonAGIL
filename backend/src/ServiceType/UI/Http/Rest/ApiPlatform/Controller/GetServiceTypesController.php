<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\UI\Http\Rest\ApiPlatform\Controller;

use App\Authorization\Application\Service\Authorizer;
use App\Authorization\Domain\ValueObject\Action;
use App\Authorization\Domain\ValueObject\Resource;
use App\Authorization\Infrastructure\Trait\AuthorizationTrait;
use App\ServiceType\Application\GetServiceTypes\GetServiceTypesQuery;
use App\ServiceType\Application\Response\ServiceTypesResponse;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

#[AsController]
class GetServiceTypesController extends AbstractController {
    use AuthorizationTrait;
    public function __construct(
        private readonly Authorizer $authorizer,
        private readonly QueryBus $queryBus,
    ) {
    }
    public function __invoke(): JsonResponse {
        $authorizationContext = $this->getAuthorizationContext(
            Resource::ServiceType,
            Action::Read,
            []
        );
        if (!$this->authorizer->authorize($authorizationContext)) {
            throw new AccessDeniedHttpException("Access Denied");
        }

        /** @var ServiceTypesResponse $return */
        $return = $this->queryBus->ask(
            new GetServiceTypesQuery()
        );
        return new JsonResponse($return);
    }
}
