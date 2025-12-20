<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Shared\Infrastructure\Context;

interface ContextService
{
    public static function set(string $attribute, mixed $data): void;
    public function get(string $attribute): mixed;
}
