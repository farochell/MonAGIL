<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  mon-agil
 */

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

enum ErrorCode: string
{
    case AUTH_MISSING_TOKEN = 'AUTH_MISSING_TOKEN';
    case AUTH_INVALID_TOKEN = 'AUTH_INVALID_TOKEN';
    case AUTH_FORBIDDEN = 'AUTH_FORBIDDEN';
    case NETWORK_DISCONNECTED = 'NETWORK_DISCONNECTED';
    case ANALYTIC_INVALID_PERIOD = 'ANALYTIC_INVALID_PERIOD';
    case UNKNOWN_ERROR = 'UNKNOWN_ERROR';
    case MISSING_PARAMETERS = 'MISSING_PARAMETERS';
    case ENTITY_NOT_FOUND = 'ENTITY_NOT_FOUND';
    case EXPIRED_TOKEN = 'EXPIRED_TOKEN';
    case INVALID_TOKEN = 'INVALID_TOKEN';
    case EMAIL_ALREADY_EXISTS = 'EMAIL_ALREADY_EXISTS';
    case INVALID_CREDENTIALS = 'INVALID_CREDENTIALS';
    case INVALID_ANALYTIC_CODE = 'INVALID_ANALYTIC_CODE';
    case ACCESS_FORBIDDEN = 'ACCESS_FORBIDDEN';
    case EVENT_SUBSCRIBER_EXCEPTION = 'EVENT_SUBSCRIBER_EXCEPTION';
    case USER_NOT_FOUND = 'USER_NOT_FOUND';

    case AUTH_TOKEN_EXPIRED = 'AUTH_TOKEN_EXPIRED';

    public static function fromHttpStatusCode(int $statusCode): self
    {
        return match ($statusCode) {
            401 => self::AUTH_MISSING_TOKEN,
            403 => self::ACCESS_FORBIDDEN,
            404 => self::ENTITY_NOT_FOUND,
            default => self::UNKNOWN_ERROR,
        };
    }

    public function toString(): string
    {
        return $this->value;
    }
}
