<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\Shared\Domain\Exception\EntityPersistenceException;
use App\Shared\Infrastructure\Repository\BaseRepository;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\UserId;
use App\User\Infrastructure\Doctrine\Mapping\User as DoctrineUser;
use App\User\Infrastructure\Doctrine\Mapping\UserDoctrine;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * @extends BaseRepository<User>
 */
class MysqlUserRepository extends BaseRepository implements UserRepository {

    public function __construct(
        ManagerRegistry $managerRegistry,
        LoggerInterface $userLogger
    ) {
        parent::__construct(
            $managerRegistry,
            UserDoctrine::class,
            'User',
            $userLogger
        );
    }
    public function findByUserId(UserId $userId): ?User
    {
        $user = $this->getEntityManager()->getRepository(UserDoctrine::class)->findOneBy([
            "userId" => $userId
        ]);

        if ($user === null) {
            $this->logAndThrowNotFoundException($userId->value());
            return null;
        }

        return $this->transformEntity($user);
    }

    public function save(User $user): void {
        try {
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

        } catch (Throwable $e) {
            $exception = EntityPersistenceException::fromPrevious(
                $this->entityName,
                $e
            );
            $this->logAndThrowException(
                $exception,
                $user,
                [  'action' => 'save',  'data' => $this->serializeEntity($user)]
            );
        }
    }

    public function findByEmail(Email $email): ?User
    {
        $user = $this->getEntityManager()
            ->getRepository(UserDoctrine::class)
            ->findOneBy(['email' => $email->value()]);
        if ($user === null) {
            $this->logAndThrowNotFoundException($email->value());
            return null;
        }
        return $this->transformEntity($user);
    }

    public function findByToken(string $token): ?User
    {
        $user = $this->getEntityManager()
            ->getRepository(UserDoctrine::class)
            ->findOneBy(['confirmationToken' => $token]);
        if ($user === null) {
            $this->logAndThrowNotFoundException($token);
        }

        return $this->transformEntity($user);
    }

    private function transformEntity(UserDoctrine $user): User {
        return new User(
            $user->email,
            $user->hashedPassword,
            $user->roles,
            $user->registrationDate,
            $user->isEnabled,
            $user->isDeleted,
            $user->mangoUserId,
            $user->isPro,
            $user->enableBankTransfer,
            $user->apiToken,
            $user->lastLogin,
            id: $user->id
        );
    }
}
