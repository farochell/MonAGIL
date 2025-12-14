<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  defi-fullstack-app
 */

declare(strict_types=1);

namespace App\Shared\UI\Http\Rest\Exception\Formatter;

use ApiPlatform\Validator\Exception\ValidationException;
use App\Shared\Domain\Exception\ErrorCode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait ErrorFormatterTrait
{
    public function formatError(\Throwable $error): ?JsonResponse
    {


        if ($error instanceof ValidationException) {
            return new JsonResponse(SymfonyValidationExceptionFormatter::format($error), 400);
        }

        if ($error instanceof HttpException) {
            return new JsonResponse(SymfonyHttpExceptionFormatter::format($error), $error->getStatusCode());
        }

        return new JsonResponse([
            'code' => ErrorCode::UNKNOWN_ERROR,
            'message' => 'Erreur inconnue.',
            'details' => [
                $error->getMessage(),
            ],
        ], $error->getCode());
    }
}
