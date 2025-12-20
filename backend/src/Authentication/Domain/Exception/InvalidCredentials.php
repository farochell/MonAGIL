<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authentication\Domain\Exception;

use App\Shared\Domain\Exception\ApiExceptionInterface;
use App\Shared\Domain\Exception\ApiExceptionTrait;
use App\Shared\Domain\Exception\ErrorCode;
use DomainException;

class InvalidCredentials extends DomainException implements ApiExceptionInterface {
    use ApiExceptionTrait;

    public function __construct()
    {
        parent::__construct(
            message: 'Username or password is incorrect',
            code: 401
        );
    }
    public function getErrorCode(): ErrorCode {
       return ErrorCode::INVALID_CREDENTIALS;
    }

    public function getDetails(): array {
        return [];
    }
}
