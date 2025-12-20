<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authorization\Domain\ValueObject;

enum Action
{
    case Create;
    case Read;
    case ReadAll;
    case Update;
    case Delete;
    case UpdatePassword;
}
