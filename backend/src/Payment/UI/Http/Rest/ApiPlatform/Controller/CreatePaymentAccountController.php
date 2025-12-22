<?php

declare(strict_types=1);

namespace App\Payment\UI\Http\Rest\ApiPlatform\Controller;

use App\Authorization\Application\Service\Authorizer;
use App\Authorization\Infrastructure\Trait\AuthorizationTrait;
use App\Payment\Application\CreatePaymentAccount\CreatePaymentAccountCommand;
use App\Payment\UI\Http\Rest\ApiPlatform\Input\CreatePaymentAccountInput;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\UI\Http\Rest\Exception\Formatter\ErrorFormatterTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CreatePaymentAccountController extends AbstractController {
    use AuthorizationTrait;
    use ErrorFormatterTrait;

    public function __construct(
        private readonly CommandBus $commandBus,
        private Authorizer $authorizer
    )
    {
    }

    public function __invoke(
        #[MapRequestPayload] CreatePaymentAccountInput $input
    ): JsonResponse
    {
        try {
            $result = $this->commandBus->dispatch(
                new CreatePaymentAccountCommand(
                    $input->legalPersonType,
                    $input->companyName,
                    $input->companyNumber,
                    $input->email,
                    $input->firstName,
                    $input->lastName,
                    $input->birthday,
                    $input->addressLine1,
                    $input->addressLine2,
                    $input->city,
                    $input->region,
                    $input->postalCode,
                    $input->country,
                    $input->nationality,
                )
            );

            return $this->json($result);
        } catch (\Throwable $e) {
            return $this->formatError($e);
        }
    }
}
