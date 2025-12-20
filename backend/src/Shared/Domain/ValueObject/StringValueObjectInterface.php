<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  mon-agil
 */

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

interface StringValueObjectInterface
{
    public function __construct(string $value);

    public static function fromString(string $value): self;

    public function value(): string;
}
