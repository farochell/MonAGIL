<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\UI\Http\Rest\ApiPlatform\Input;

use Symfony\Component\Validator\Constraints as Assert;


class CreatePaymentAccountInput
{
    public ?string $legalPersonType = null;
    public ?string $companyName;
    public ?string $companyNumber;
    public string $email;
    public ?string $firstName;
    public ?string $lastName;
    public ?int $birthday;

    #[Assert\NotBlank]
    public string $addressLine1;

    #[Assert\NotBlank]
    public string $addressLine2;

    #[Assert\NotBlank]
    public string $city;

    public ?string $region;

    #[Assert\NotBlank]
    public string $postalCode;

    #[Assert\NotBlank]
    public string $country;

    #[Assert\NotBlank]
    public string $nationality;
}
