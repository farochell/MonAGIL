<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Application\GetServiceTypes;

use App\Shared\Domain\Bus\Query\Query;

class GetServiceTypesQuery implements Query {
    public function __construct() {}
}
