<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Domain\Exception;

use App\Shared\Domain\Exception\ApiExceptionInterface;
use App\Shared\Domain\Exception\ApiExceptionTrait;
use App\Shared\Domain\Exception\ErrorCode;

class PrePaymentNotAuthorizedException extends \DomainException implements ApiExceptionInterface
{
    use ApiExceptionTrait;
    public function __construct()
    {
        parent::__construct(
            message: 'Pre payment not authorized',
            code: 400,
        );
    }

    public function getErrorCode(): ErrorCode
    {
        return ErrorCode::PRE_PAYMENT_NOT_AUTHORIZED;
    }

    public function getDetails(): array
    {
        return [
            'error' => 'Pre payment not authorized',
        ];
    }

}
