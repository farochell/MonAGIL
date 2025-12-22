<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Application\CreatePaymentAccount;

use App\Payment\Domain\Entity\PaymentAccount;
use App\Shared\Application\SerializableResponse;
use App\Shared\Domain\Bus\Command\CommandResponse;

class CreatePaymentAccountResponse extends SerializableResponse implements CommandResponse {

    public function __construct(
        public PaymentAccount $paymentAccount
    ) {
    }

    public static function fromDomain(PaymentAccount $paymentAccount): self
    {
        return new self($paymentAccount);
    }

    public function jsonSerialize(): array {
       return [
           'id' => $this->paymentAccount->userId->value(),
           'provider' => $this->paymentAccount->provider->value,
           'providerAccountId' => $this->paymentAccount->providerAccountId,
       ];
    }
}
