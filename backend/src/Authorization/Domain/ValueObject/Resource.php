<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authorization\Domain\ValueObject;

enum Resource
{
    case User;
    case Role;
    case ServiceType;
}
