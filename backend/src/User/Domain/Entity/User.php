<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Authentication\Domain\ValueObject\HashedPassword;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\User\Domain\Event\UserCreatedEvent;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\LegacyUserId;
use App\User\Domain\ValueObject\MangoUserId;
use App\User\Domain\ValueObject\Role;
use App\User\Domain\ValueObject\Roles;
use App\User\Domain\ValueObject\UserId;
use DateTimeImmutable;

class User extends AggregateRoot
{
    public function __construct(
        public readonly Email $email,
        public readonly HashedPassword $hashedPassword,
        public readonly Roles $roles,
        public readonly DateTimeImmutable $registrationDate,
        public  bool $isEnabled = false,
        public  bool $isDeleted = false,
        public readonly ?MangoUserId $mangoUserId = null,
        public readonly ?bool $isPro = false,
        public readonly ?bool $enableBankTransfer = false,
        public readonly ?string $apiToken = null,
        public readonly ?DateTimeImmutable $lastLogin = null,
        public ?string $confirmationToken = null,
        public ?string $emailInVerification = null,
        public ?string $contactOrigin = null,
        public readonly ?UserId $userId = null,
        public readonly ?LegacyUserId $id = null,
    )
    {}

    public static function create(
        Email $email,
        HashedPassword $hashedPassword,
        Roles $roles,
        ?bool $isPro = false,
    ): User {
        $confirmationToken = md5(uniqid($email->value(), true));
        $user = new self(
            email: $email,
            hashedPassword: $hashedPassword,
            roles: $roles,
            registrationDate: new DateTimeImmutable(),
            isPro: $isPro,
            confirmationToken: $confirmationToken,
            emailInVerification: $email->value(),
            userId: UserId::random(),
        );

        $user->recordThat(
            new UserCreatedEvent(
                $user->userId->value(),
                $user->email->value(),
                $user->mangoUserId->value(),
                $user->isPro,
                $user->enableBankTransfer
            )
        );

        return $user;
    }

    public function validateToken(): User {
        $this->isEnabled = true;
        $this->confirmationToken = null;
        $this->emailInVerification = null;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isArtisan(): bool
    {
        return $this->roles->has(Role::artisan);
    }

    public function isAdmin(): bool
    {
        return $this->roles->has(Role::admin);
    }

    public function isPropertyManager(): bool
    {
        return $this->roles->has(Role::propertyManager);
    }

    private function generateToken(): string
    {
        return md5(uniqid($this->email->value(), true));
    }

    public function generateTokenAndSave(): self
    {
        $this->confirmationToken = $this->generateToken();
        return $this;
    }

}
