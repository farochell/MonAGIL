<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;

class UserCreatedEvent extends DomainEvent
{
    public function __construct(
        public readonly string $userId,
        public readonly string $email,
        public readonly string $mangoUserId,
        public readonly bool $isPro,
        public readonly bool $enableBankTransfer
    ){}
}
