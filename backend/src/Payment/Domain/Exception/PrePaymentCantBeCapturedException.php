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

class PrePaymentCantBeCapturedException extends \Exception implements ApiExceptionInterface
{
    use ApiExceptionTrait;
    public function __construct()
    {
        parent::__construct(
            message: 'Pre payment cant be captured',
            code: 400
        );
    }

    public function getErrorCode(): ErrorCode {
        return ErrorCode::PRE_PAYMENT_CAN_BE_CAPTURED;
    }

    public function getDetails(): array {
        // TODO: Implement getDetails() method.
    }

    public function toOpenApiError(): array {
        // TODO: Implement toOpenApiError() method.
    }
}
