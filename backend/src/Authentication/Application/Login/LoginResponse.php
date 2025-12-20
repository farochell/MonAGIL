<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  api-monagil
 */
declare(strict_types=1);

namespace App\Authentication\Application\Login;

use App\Shared\Application\SerializableResponse;
use App\Shared\Domain\Bus\Query\QueryResponse;

class LoginResponse extends SerializableResponse implements QueryResponse
{
    /**
     * @param array<string> $roles
     */
    public function __construct(public int $userId, public string $username, public array $roles)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'userId' => $this->userId,
            'username' => $this->username,
            'roles' => $this->roles,
        ];
    }
}
