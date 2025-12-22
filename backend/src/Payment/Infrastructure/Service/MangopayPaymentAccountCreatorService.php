<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Infrastructure\Service;

use App\Payment\Domain\Entity\PaymentAccount;
use App\Payment\Domain\Entity\PaymentProfile;
use App\Payment\Domain\Service\PaymentAccountCreator;
use App\Payment\Domain\ValueObject\Provider;
use MangoPay\Libraries\Exception as MGPException;

use MangoPay\Libraries\ResponseException as MGPResponseException;
use App\User\Domain\ValueObject\UserId;
use MangoPay\Address;
use MangoPay\LegalRepresentative;
use MangoPay\MangoPayApi;
use MangoPay\UserLegalSca;
use Psr\Log\LoggerInterface;

class MangopayPaymentAccountCreatorService implements PaymentAccountCreator {

    private MangoPayApi $mangoPayApi;

    public function __construct(
        MangopayApiFactory $factory,
        private LoggerInterface $logger
    ) {
        $this->mangoPayApi = $factory->create();
    }

    public function create(UserId $userId, PaymentProfile $paymentProfile): ?PaymentAccount {
        try {
            $legalRepresentative = new LegalRepresentative();
            $legalRepresentative->FirstName = $paymentProfile->firstName;
            $legalRepresentative->LastName = $paymentProfile->lastName;
            $legalRepresentative->Email = $paymentProfile->email->value();
            $legalRepresentative->Birthday = $paymentProfile->birthday;
            $legalRepresentative->CountryOfResidence = $paymentProfile->country;
            $legalRepresentative->Nationality = $paymentProfile->nationality;

            $address = new Address();
            $address->AddressLine1 = $paymentProfile->addressLine1;
            $address->AddressLine2 = $paymentProfile->addressLine2;
            $address->City = $paymentProfile->city;
            $address->Region = $paymentProfile->region;
            $address->PostalCode = $paymentProfile->postalCode;
            $address->Country = $paymentProfile->country;

            $mangoPayUser = new UserLegalSca();
            $mangoPayUser->Name = $paymentProfile->companyName;
            $mangoPayUser->Email = $paymentProfile->email->value();
            $mangoPayUser->LegalPersonType = $paymentProfile->legalPersonType->value;
            $mangoPayUser->HeadquartersAddress = $address;
            $mangoPayUser->LegalRepresentative = $legalRepresentative;
            $mangoPayUser->UserCategory =  'OWNER';
            $mangoPayUser->LegalRepresentativeAddress = $address;
            $mangoPayUser->CompanyNumber = $paymentProfile->companyNumber;
            $mangoPayUser->TermsAndConditionsAccepted = true;
            $response = $this->mangoPayApi->Users->Create($mangoPayUser);

            return new PaymentAccount(
                $userId,
                Provider::MANGOPAY,
                $response->Id
            );
        } catch (MGPResponseException $exception) {
            $this->logger->error('Mangopay API error: ' . $exception->GetErrorDetails());
        } catch (MGPException $exception) {
            $this->logger->error('Mangopay API error: ' . $exception->getMessage());
        }

        return null;
    }
}
