<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  api-monagil
 */
declare(strict_types=1);

namespace App\User\Domain\Service;

use App\Authentication\Domain\Service\SecretEncoder;
use App\Authentication\Domain\ValueObject\HashedPassword;
use App\Authentication\Domain\ValueObject\Password;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\EmailAlreadyExistException;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Role;
use App\User\Domain\ValueObject\Roles;

final class UserCreator
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly SecretEncoder $encoder,
    ) {}

    public function create(
        Email $email,
        Password $plainPassword,
        Role $role,
        ?bool $isPro = false
    ): User {
        if ($this->repository->findByEmail($email)) {
            throw new EmailAlreadyExistException($email->value());
        }

        $hashed = HashedPassword::fromString(
            $this->encoder->encode($plainPassword)->value()
        );

        $user = User::create(
            $email,
            $hashed,
            Roles::fromArray([$role->value]),
            isPro: $isPro
        );

        $this->repository->save($user);

        return $user;
    }
}
