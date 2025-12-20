<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Mapping;

use App\Authentication\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\LegacyUserId;
use App\User\Domain\ValueObject\MangoUserId;
use App\User\Domain\ValueObject\Roles;
use App\User\Domain\ValueObject\UserId;
use App\User\Infrastructure\Doctrine\Type\RolesType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user')]
class UserDoctrine {

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'legacy_user_id')]
    public LegacyUserId $id;

    #[ORM\Column(name: 'uuid', type: 'user_id', unique: true)]
    public UserId $userId;

    #[ORM\Column(name: 'email', type: 'email', length: 100, unique: true)]
    public Email $email;

    #[ORM\Column(name: 'password', type: 'hashed_password', length: 100)]
    public HashedPassword $hashedPassword;

    #[ORM\Column(name: 'roles', type: 'roles')]
    public Roles $roles;

    #[ORM\Column(name: 'date_inscription', type: 'datetime_immutable')]
    public \DateTimeImmutable $registrationDate;

    #[ORM\Column(name: 'is_enabled', type: 'boolean')]
    public bool $isEnabled;

    #[ORM\Column(name: 'is_delete', type: 'boolean')]
    public bool $isDeleted;

    #[ORM\Column(name: 'mango_user_id', type: 'mango_user_id', length: 36, nullable: true)]
    public ?MangoUserId $mangoUserId = null;

    #[ORM\Column(name: 'is_pro', type: 'boolean', nullable: true)]
    public ?bool $isPro = null;

    #[ORM\Column(name: 'enable_bank_transfer', type: 'boolean', nullable: true)]
    public ?bool $enableBankTransfer = null;

    #[ORM\Column(name: 'api_token', nullable: true)]
    public ?string $apiToken = null;

    #[ORM\Column(name: 'last_login', type: 'datetime_immutable', nullable: true)]
    public ?\DateTimeImmutable $lastLogin = null;

    #[ORM\Column(name: 'confirmation_token', type:'string', nullable: true)]
    public ?string $confirmationToken = null;

    #[ORM\Column(name: 'email_in_verification', type: 'string', nullable: true)]
    public ?string $emailInVerification = null;

    #[ORM\Column(name: 'contact_origin', type:'string', nullable: true)]
    public ?string $contactOrigin = null;

}
