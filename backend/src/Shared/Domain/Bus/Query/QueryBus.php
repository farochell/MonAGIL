<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  mon-agil
 */

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Query;

interface QueryBus
{
    public function ask(Query $query): ?QueryResponse;
}
