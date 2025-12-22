<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Domain\Entity;

use App\Payment\Domain\ValueObject\Money;

class PaymentSplit
{
    public function __construct(
        public Money $artisanAmount,
        public Money $platformAmount
    ) {}
}
