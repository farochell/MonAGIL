<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Service;

use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\Email;

class UserFinder {
    public static array $users = [];

    public function __construct (private readonly UserRepository $userRepository) {}

    public function getByEmail(Email $email): ?User
    {
        if (!isset(self::$users[$email->value()])) {
            self::$users[$email->value()] = $this->userRepository->findByEmail($email);
        }
        return self::$users[$email->value()];
    }
}
