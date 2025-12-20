<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  mon-agil
 */

declare(strict_types=1);

namespace App\Shared\UI\Http\Rest\Exception\Formatter;

use ApiPlatform\Validator\Exception\ValidationException;
use App\Shared\Domain\Exception\ErrorCode;
use Symfony\Component\Validator\ConstraintViolationInterface;

class SymfonyValidationExceptionFormatter
{
    /**
     * @return mixed[]
     */
    public static function format(ValidationException $exception): array
    {
        $details = [];

        foreach ($exception->getConstraintViolationList() as $violation) {
            /** @var ConstraintViolationInterface $violation */
            $propertyPath = $violation->getPropertyPath();
            $message = $violation->getMessage();

            $details[] = $propertyPath
                ? "{$propertyPath}: {$message}"
                : $message;
        }

        return [
            'code' => ErrorCode::MISSING_PARAMETERS,
            'message' => 'Donnée invalides.',
            'details' => $details,
        ];
    }
}
