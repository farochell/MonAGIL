<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  mon-agil
 */

declare(strict_types=1);

namespace App\Shared\UI\Http\Rest\Exception;

use App\Shared\UI\Http\Rest\Exception\Formatter\ErrorFormatterTrait;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiExceptionListener
{
    use ErrorFormatterTrait;

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $prevException = $exception->getPrevious();
        if ($exception instanceof HttpException || $prevException instanceof \Error) {
            $response = $this->formatError($exception);
            $event->setResponse($response);
        }
    }
}
