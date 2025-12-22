<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Domain\Entity;

use App\Payment\Domain\Exception\LegalUserInvalidException;
use App\Payment\Domain\Exception\NaturalUserInvalidException;
use App\Payment\Domain\ValueObject\LegalPersonType;
use App\Payment\Domain\ValueObject\PaymentAccountType;
use App\User\Domain\ValueObject\Email;

final class PaymentProfile
{
    public function __construct(
        public ?string $companyName,
        public ?string $companyNumber,
        public Email $email,
        public ?string $firstName,
        public ?string $lastName,
        public ?int $birthday,
        public string $addressLine1,
        public string $addressLine2,
        public string $city,
        public ?string $region,
        public string $postalCode,
        public string $country,
        public string $nationality,
        public PaymentAccountType $type,
        public ?LegalPersonType $legalPersonType = null,
    ) {}

    public static function legal(
        string $companyName,
        string $companyNumber,
        Email $email,
        string $firstName,
        string $lastName,
        int $birthday,
        string $addressLine1,
        string $addressLine2,
        string $city,
        string $region,
         string $postalCode,
         string $country,
        string $nationality,
        ?LegalPersonType $legalPersonType = null,
    ): self {
        return new self(
            $companyName,
            $companyNumber,
            $email,
            $firstName,
            $lastName,
            $birthday,
            $addressLine1,
            $addressLine2,
            $city,
            $region,
            $postalCode,
            $country,
            $nationality,
            PaymentAccountType::LEGAL,
            $legalPersonType,
        );
    }

    private function validate(): void
    {
        if ($this->type === PaymentAccountType::NATURAL) {
            if (!$this->firstName || !$this->lastName) {
                throw new NaturalUserInvalidException();
            }
        }

        if ($this->type === PaymentAccountType::LEGAL) {
            if (
                !$this->companyName ||
                !$this->companyNumber ||
                !$this->firstName ||
                !$this->lastName
            ) {
                throw new LegalUserInvalidException();
            }
        }
    }


}
