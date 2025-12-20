<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\User\Domain\ValueObject\Firstname;
use App\User\Domain\ValueObject\Lastname;
use App\User\Domain\ValueObject\LegacyUserId;
use App\User\Domain\ValueObject\Name;
use DateTimeImmutable;

class PersonalInfo {
    public function __construct(
        public readonly User $user,
        public readonly DateTimeImmutable $createdAt,
        public readonly ?Name $name = null,
        public readonly ?Firstname $firstname = null,
        public readonly ?Lastname $lastname = null,
        public readonly ?string $address = null,
        public readonly ?string $site = null,
        public readonly ?string $phone = null,
        public readonly ?string $siret = null,
        public readonly ?string $imageName = null,
        public readonly ?string $justificativeName = null,
        public readonly ?string $countryOfResidence = null,
        public readonly ?string $birthday = null,
        public readonly ?string $nationality = null,
        public readonly ?string $department = null,
        public readonly ?string $postalCode = null,
        public readonly ?string $city = null,
        public readonly ?string $iban = null,
        public readonly ?string $bic = null,
        public readonly ?string $bankAliasId = null,
        public readonly ?string $notificationEmails = null,
        public readonly ?string $notificationSettings = null,
        public readonly ?DateTimeImmutable $updatedAt = null,
        public readonly ?LegacyUserId $userCreatedId = null,
        public readonly ?LegacyUserId $userUpdatedId = null,
    ) {}

    public static function create(User $user, LegacyUserId $userCreatedId): self
    {
        return new self(
            user: $user, createdAt: new DateTimeImmutable(), imageName: '', userCreatedId: $userCreatedId,
        );
    }

    public function update(
        Firstname $firstname,
        Lastname $lastname,
        Name $name,
        string $address,
        string $site,
        string $phone,
        string $siret,
        string $countryOfResidence,
        string $birthday,
        string $nationality,
        string $department,
        string $postalCode,
        string $city,
        string $iban,
        string $bic,
        string $notificationEmails,
        LegacyUserId $userUpdatedId
    ): self {
        return new self(
            user: $this->user,
            createdAt: $this->createdAt,
            name: $name,
            firstname: $firstname,
            lastname: $lastname,
            address: $address,
            site: $site,
            phone: $phone,
            siret: $siret,
            imageName: $this->imageName,
            justificativeName: $this->justificativeName,
            countryOfResidence: $countryOfResidence,
            birthday: $birthday,
            nationality: $nationality,
            department: $department,
            postalCode: $postalCode,
            city: $city,
            iban: $iban,
            bic: $bic,
            bankAliasId: $this->bankAliasId,
            notificationEmails: $notificationEmails,
            notificationSettings: $this->notificationSettings,
            updatedAt: new DateTimeImmutable(),
            userUpdatedId: $userUpdatedId,
        );
    }
}
