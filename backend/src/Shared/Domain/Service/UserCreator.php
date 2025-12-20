<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Shared\Domain\Service;

use App\Authentication\Domain\Service\SecretEncoder;
use App\Authentication\Domain\ValueObject\Password;
use App\Shared\Domain\Bus\Event\EventBus;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\EmailAlreadyExistException;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Role;
use App\User\Domain\ValueObject\Roles;

class UserCreator
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly SecretEncoder $secretEncoder,
        public readonly EventBus $eventBus
    )
    {
    }

    public function create(
        Email $email,
        Password $plainPassword,
        Role $role,
        bool $isPro = false
    ): User {
        if ($this->userRepository->findByEmail($email)) {
            throw new EmailAlreadyExistException($email->value());
        }

        $hashed = $this->secretEncoder->encode($plainPassword);

        $user = User::create(
            $email,
            $hashed,
            Roles::fromArray([$role->value]),
            isPro: $isPro
        );

        $this->eventBus->publish(...$user->pullDomainEvents());

        return $user;
    }
}
