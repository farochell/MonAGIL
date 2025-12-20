<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authentication\UI\Http\Rest\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Authentication\Application\Login\LoginQuery;
use App\Authentication\Domain\ValueObject\UserIdentity;
use App\Authentication\UI\Http\Rest\ApiPlatform\Resource\LoginResource;
use App\Authentication\Domain\Service\AccessTokenGenerator;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\QueryResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

readonly class LoginProcessor implements ProcessorInterface
{
    public function __construct(
        private QueryBus $queryBus,
        private AccessTokenGenerator $accessTokenGenerator
    )
    {

    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): JsonResponse {
        Assert::isInstanceOf($data, LoginResource::class);
        $loginPayload = $data;
        $commandResponse = $this->login($loginPayload);
        $userIdentity = new UserIdentity(
            $commandResponse->userId,
            $commandResponse->username,
            $commandResponse->roles,
        );

        return new JsonResponse([
            'token' => $this->accessTokenGenerator->generate($userIdentity),
        ], Response::HTTP_OK);
    }

    private function login(LoginResource $loginResource): QueryResponse
    {
        return $this->queryBus
            ->ask(
                new LoginQuery(
                    $loginResource->username,
                    $loginResource->password,
                )
            );
    }
}
