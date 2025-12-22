<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Domain\ValueObject;

enum Provider : string
{
    case MANGOPAY = 'MANGOPAY';
}
