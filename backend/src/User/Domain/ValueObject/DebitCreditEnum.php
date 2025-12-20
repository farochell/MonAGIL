<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\ValueObject;

enum DebitCreditEnum: string {
    case debit = 'debit';
    case credit = 'credit';
}
