<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Application\CreatePaymentAccount;

use App\Payment\Domain\Entity\PaymentProfile;
use App\Payment\Domain\Service\PaymentAccountCreator;
use App\Payment\Domain\ValueObject\LegalPersonType;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\UserId;
use DomainException;

class CreatePaymentAccountCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly PaymentAccountCreator $paymentAccountCreator,
        private readonly UserRepository $userRepository
    ) {}

    public function __invoke(
        CreatePaymentAccountCommand $command
    ): CreatePaymentAccountResponse {
        $email = Email::fromString($command->email);
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            throw new UserNotFoundException($command->email);
        }
        if (!$user->isArtisan()) {
            throw new DomainException(
                'Only artisans can create payment accounts'
            );
        }
        $profilePayment = PaymentProfile::legal(
            $command->companyName,
            $command->companyNumber,
            $email,
            $command->firstName,
            $command->lastName,
            $command->birthday,
            $command->addressLine1,
            $command->addressLine2,
            $command->city,
            $command->region,
            $command->postalCode,
            $command->country,
            $command->nationality,
            LegalPersonType::tryFrom($command->legalPersonType),
        );
        $account = $this->paymentAccountCreator->create(
            $user->userId,
            $profilePayment
        );

        return CreatePaymentAccountResponse::fromDomain($account);
    }
}
