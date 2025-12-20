<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\ApiExceptionInterface;
use App\Shared\Domain\Exception\ApiExceptionTrait;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\Exception\ErrorCode;

class EmailAlreadyExistException extends DomainException implements ApiExceptionInterface
{
    use ApiExceptionTrait;

    public function __construct(private readonly string $email)
    {
        parent::__construct(
            message: 'Email déjà utilisé',
            code: 409
        );
    }

    public function getErrorCode(): ErrorCode {
        return ErrorCode::EMAIL_ALREADY_EXISTS;
    }

    public function getDetails(): array {
        return [
            'email' =>$this->email
        ];
    }
}
