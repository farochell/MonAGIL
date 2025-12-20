<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  mon-agil
 */

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use DomainException;

abstract class DomainError extends DomainException implements ApiExceptionInterface
{
    public function __construct(public string $msg = '')
    {
        parent::__construct($msg);
    }
}
