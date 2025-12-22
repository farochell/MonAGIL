<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Domain\Service;

use App\Payment\Domain\Entity\PaymentAccount;
use App\Payment\Domain\Entity\PaymentProfile;
use App\User\Domain\ValueObject\UserId;

interface PaymentAccountCreator {
    public function create(
        UserId $userId,
        PaymentProfile $paymentProfile
    ): ?PaymentAccount;
}
