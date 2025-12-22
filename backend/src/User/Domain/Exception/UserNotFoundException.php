<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\ApiExceptionInterface;
use App\Shared\Domain\Exception\ApiExceptionTrait;
use App\Shared\Domain\Exception\ErrorCode;
use DomainException;

class UserNotFoundException extends DomainException implements ApiExceptionInterface
{
    use ApiExceptionTrait;

    public function __construct(private readonly string $email)
    {
        parent::__construct(
            message: 'User not found',
            code: 404
        );
    }

    public function getErrorCode(): ErrorCode {
        return ErrorCode::USER_NOT_FOUND;
    }

    public function getDetails(): array {
        return [
            'message' => 'User not found with email: ' . $this->email
        ];
    }
}
