<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Application\CreatePaymentAccount;

use App\Shared\Domain\Bus\Command\Command;

class CreatePaymentAccountCommand  implements Command
{
    public function __construct(
        public ?string $legalPersonType = null,
        public ?string $companyName,
        public ?string $companyNumber,
        public string $email,
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
    ) {}
}
