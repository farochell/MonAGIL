<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Domain\Entity;

use App\Payment\Domain\Exception\PrePaymentCantBeCapturedException;
use App\Payment\Domain\Exception\PrePaymentNotAuthorizedException;
use App\Payment\Domain\ValueObject\Money;
use App\Payment\Domain\ValueObject\PaymentStatus;

class PrePayment
{
    public function __construct(
        public readonly string $id,
        public readonly Money $amount,
        public PaymentStatus $status
    ) {}

    public function authorize(): void
    {
        if ($this->status !== PaymentStatus::PENDING) {
            throw new PrePaymentNotAuthorizedException();
        }

        $this->status = PaymentStatus::AUTHORIZED;
    }

    public function capture(): void
    {
        if ($this->status !== PaymentStatus::AUTHORIZED) {
            throw new PrePaymentCantBeCapturedException();
        }

        $this->status = PaymentStatus::CAPTURED;
    }

    public function fail(): void
    {
        $this->status = PaymentStatus::FAILED;
    }

    public function isCapturable(): bool
    {
        return $this->status === PaymentStatus::AUTHORIZED;
    }

}
