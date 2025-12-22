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

class NegativeValueException extends \InvalidArgumentException  implements ApiExceptionInterface
{
    use ApiExceptionTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function getErrorCode(): ErrorCode
    {
        return ErrorCode::NEGATIVE_AMOUNT_VALUE;
    }

    public function getDetails(): array
    {
        return [
            'message' => 'Negative value not allowed'
        ];
    }
}
