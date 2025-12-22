<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Domain\Entity;

use App\Payment\Domain\ValueObject\Provider;
use App\User\Domain\ValueObject\UserId;

class PaymentAccount {
    public function __construct(
        public readonly UserId $userId,
        public readonly Provider $provider,
        public readonly string $providerAccountId,
    ) {}
}
