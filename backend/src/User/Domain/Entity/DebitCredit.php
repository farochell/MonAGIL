<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\User\Domain\ValueObject\DebitCreditEnum;
use App\User\Domain\ValueObject\LegacyUserId;
use DateTimeImmutable;

class DebitCredit {
    private ?int $id = null;
    public function __construct(
        public LegacyUserId $userId,
        public float $amount,
        public DebitCreditEnum $type,
        public LegacyUserId $userCreatedId,
        public ?LegacyUserId $userUpdatedId = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {}

    public function getId(): int {
        return $this->id;
    }

    public static function create(
        LegacyUserId $userId,
        float $amount,
        DebitCreditEnum $type,
        LegacyUserId $userCreatedId
    ): self {
        return new self(
            $userId,
            $amount,
            $type,
            $userCreatedId,
            createdAt: new DateTimeImmutable()
        );
    }

    public function updateAmount(float $amount, LegacyUserId $userUpdatedId): self {
        return new self(
            $this->userId,
            amount: $this->amount +  $amount,
            type: $this->type,
            userCreatedId: $this->userCreatedId,
            userUpdatedId: $userUpdatedId,
            createdAt: $this->createdAt,
            updatedAt: new \DateTimeImmutable(),
        );
    }
}
