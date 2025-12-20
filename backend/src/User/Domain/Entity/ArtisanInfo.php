<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\User\Domain\ValueObject\LegacyUserId;
use DateTimeImmutable;

class ArtisanInfo {
    public function __construct(
        public readonly User $user,
        public readonly DateTimeImmutable $createdAt,
        public ?int $receivedInterventionCount = 0,
        public ?string $city = null,
        public ?int $maxCoverageRadius = null,
        public ?bool $emergency = false,
        public ?string $unavailabilityStartDate = null,
        public ?string $unavailabilityEndDate = null,
        public ?bool $isUnAvailable = false,
        public readonly ?DateTimeImmutable $updatedAt = null,
        public readonly ?LegacyUserId $userCreatedId = null,
        public readonly ?LegacyUserId $userUpdatedId = null,
    ) {

    }

    public static function  create(
        User $user,
        LegacyUserId $userCreatedId,
    ): self {
        return new self(
            $user,
            createdAt: new DateTimeImmutable(),
            emergency: false,
            userCreatedId: $userCreatedId,
        );
    }

    public function updateMaxCoverageRadius (
        int $maxCoverageRadius, LegacyUserId $userUpdatedId
    ): self {
        return new self(
            user: $this->user,
            createdAt: $this->createdAt,
            receivedInterventionCount: $this->receivedInterventionCount,
            city: $this->city,
            maxCoverageRadius: $maxCoverageRadius,
            emergency: $this->emergency,
            unavailabilityStartDate: $this->unavailabilityStartDate,
            unavailabilityEndDate: $this->unavailabilityEndDate,
            isUnAvailable: $this->isUnAvailable,
            updatedAt: new DateTimeImmutable(),
            userUpdatedId: $userUpdatedId,
        );
    }

    public function updateEmergency (
        bool $emergency,
        LegacyUserId $userUpdatedId
    ): self {
        return new self(
            user: $this->user,
            createdAt: $this->createdAt,
            receivedInterventionCount: $this->receivedInterventionCount,
            city: $this->city,
            maxCoverageRadius: $this->maxCoverageRadius,
            emergency: $emergency,
            unavailabilityStartDate: $this->unavailabilityStartDate,
            unavailabilityEndDate: $this->unavailabilityEndDate,
            isUnAvailable: $this->isUnAvailable,
            updatedAt: new DateTimeImmutable(),
            userUpdatedId: $userUpdatedId,
        );
    }

    public function updateUnavailability (
        string $unavailabilityStartDate,
        string $unavailabilityEndDate,
        bool $isUnAvailable,
        LegacyUserId $userUpdatedId
    ): self {
        return new self(
            user: $this->user,
            createdAt: $this->createdAt,
            receivedInterventionCount: $this->receivedInterventionCount,
            city: $this->city,
            maxCoverageRadius: $this->maxCoverageRadius,
            emergency: $this->emergency,
            unavailabilityStartDate: $unavailabilityStartDate,
            unavailabilityEndDate: $unavailabilityEndDate,
            isUnAvailable: $isUnAvailable,
            updatedAt: new DateTimeImmutable(),
            userUpdatedId: $userUpdatedId,
        );
    }

    public function updateReceivedInterventionCount (
        int $receivedInterventionCount,
        LegacyUserId $userUpdatedId
    ): self {
        return new self(
            user: $this->user,
            createdAt: $this->createdAt,
            receivedInterventionCount: $receivedInterventionCount,
            city: $this->city,
            maxCoverageRadius: $this->maxCoverageRadius,
            emergency: $this->emergency,
            unavailabilityStartDate: $this->unavailabilityStartDate,
            unavailabilityEndDate: $this->unavailabilityEndDate,
            isUnAvailable: $this->isUnAvailable,
            updatedAt: new DateTimeImmutable(),
            userCreatedId: $this->userCreatedId,
            userUpdatedId: $userUpdatedId,
        );
    }
}
