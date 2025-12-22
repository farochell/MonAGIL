<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Domain\ValueObject;

use App\Payment\Domain\Exception\NegativeValueException;

class Money
{
    public function __construct(
        private int $amount,
        private string $currency
    ) {
        if ($amount <= 0) {
            throw new NegativeValueException();
        }
    }

    public function amount(): int { return $this->amount; }
    public function currency(): string { return $this->currency; }

}
