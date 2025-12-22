<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Domain\Service;

use App\Payment\Domain\Entity\PaymentProfile;
use App\Payment\Domain\Entity\PrePayment;
use App\Payment\Domain\ValueObject\Money;
use App\User\Domain\Entity\User;

interface PaymentProvider
{
    public function createPaymentAccount(User $user): PaymentProfile;

    public function preAuthorize(
        User $payer,
        Money $amount
    ): PrePayment;

    public function capturePrePayment(PrePayment $prePayment): void;

    public function transfer(
        PaymentProfile $from,
        PaymentProfile $to,
        Money $amount
    ): void;
}
