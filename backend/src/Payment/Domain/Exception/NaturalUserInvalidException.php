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
use DomainException;

class NaturalUserInvalidException extends DomainException  implements ApiExceptionInterface
{
    use ApiExceptionTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function getErrorCode(): ErrorCode
    {
        return ErrorCode::NATURAL_USER_INVALID;
    }

    public function getDetails(): array
    {
        return [
            'message' => 'Natural profile requires first and last name'
        ];
    }
}
