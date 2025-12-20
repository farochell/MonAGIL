<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  mon-agil
 */

declare(strict_types=1);

namespace App\Shared\UI\Http\Rest\Exception\Formatter;

use App\Shared\Domain\Exception\ErrorCode;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SymfonyHttpExceptionFormatter
{
    /**
     * @return array<string, mixed>
     */
    public static function format(HttpException $exception): array
    {
        return [
            'code' => ErrorCode::fromHttpStatusCode($exception->getStatusCode())->toString(),
            'message' => $exception->getMessage(),
            'details' => [],
        ];
    }
}
