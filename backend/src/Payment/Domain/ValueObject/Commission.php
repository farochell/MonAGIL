<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Domain\ValueObject;

use App\Payment\Domain\Exception\NegativeRateException;

class Commission
{
    public function __construct(
        private float $rate
    ) {
        if ($rate < 0 || $rate > 1) {
            throw new NegativeRateException();
        }
    }

    public function calculate(Money $amount): Money
    {
        return new Money(
            (int) round($amount->amount() * $this->rate),
            $amount->currency()
        );
    }
}
