<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Authentication\Application\Login;

use App\Authentication\Domain\Exception\InvalidCredentials;
use App\Authentication\Domain\Service\PasswordHasher;
use App\Authentication\Domain\ValueObject\Password;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Bus\Query\QueryHandler;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Role;
use Exception;
use function Lambdish\Phunctional\map;

class LoginQueryHandler implements QueryHandler {
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly PasswordHasher $passwordHasher,
    ) {}

    /**
     * @throws InvalidCredentials
     */
    public function __invoke(LoginQuery $query): LoginResponse {
        try {
            $user = $this->userRepository->findByEmail(
                Email::fromString($query->username),
            );

        } catch (Exception $e) {
            die($e->getMessage());
            throw new InvalidCredentials();
        }
        if (!$this->passwordHasher->verify(
            $user->hashedPassword,
            Password::fromString($query->password),
        )) {
            throw new InvalidCredentials();
        }
        $roles = map(
            fn(Role $role): string => $role->value,
            $user->roles
        );
        return new LoginResponse(
            $user->id->value(), $user->email->value(), $roles,
        );
    }
}
