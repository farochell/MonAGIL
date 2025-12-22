<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Domain\ValueObject;

enum LegalPersonType: string
{
    case BUSINESS = 'BUSINESS';
    case ORGANIZATION = 'ORGANIZATION';
}
