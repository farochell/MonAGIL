<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Domain\Entity;

use App\ServiceType\Domain\ValueObject\ServiceTypeId;
use App\ServiceType\Domain\ValueObject\ServiceTypeUuid;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\User\Domain\ValueObject\LegacyUserId;
use App\User\Domain\ValueObject\UserId;

class ServiceType extends AggregateRoot
{
  public function __construct(
      public readonly string $name,
      public readonly string $description,
      public readonly float $additionalPercentage,
      public readonly bool $isQuotationEnable,
      public readonly int $order,
      public readonly ?string $imageName = null,
      public readonly ?float $taxRate = null,
      public readonly ?LegacyUserId $createdBy = null,
      public readonly ?LegacyUserId $updatedBy = null,
      public readonly bool $isDeleted = false,
      public readonly ?ServiceTypeUuid $uuid = null,
      public readonly ?\DateTimeImmutable $createdAt = null,
      public readonly ?\DateTimeImmutable $updatedAt = null,
      public readonly ?ServiceTypeId $id = null,
  )  {}

    public static function create(
        string $name,
        string $description,
        string $imageName,
        float $taxRate,
        float $additionalPercentage,
        bool $isQuotationEnable,
        int $order,
        LegacyUserId $createdBy,
    ) : self {
        return new self(
            name: $name,
            description: $description,
            additionalPercentage: $additionalPercentage,
            isQuotationEnable: $isQuotationEnable,
            order: $order,
            imageName: $imageName,
            taxRate: $taxRate,
            createdBy: $createdBy,
            updatedBy: $createdBy,
            uuid: ServiceTypeUuid::random(),
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );
    }

    public function update(
        string $name,
        string $description,
        string $imageName,
        float $taxRate,
        float $additionalPercentage,
        bool $isQuotationEnable,
        int $order,
        UserId $updatedBy,
    ): self {
        return new self(
            name: $name,
            description: $description,
            imageName: $imageName,
            taxRate: $taxRate,
            additionalPercentage: $additionalPercentage,
            isQuotationEnable: $isQuotationEnable,
            order: $order,
            createdBy: $this->createdBy,
            updatedBy: $updatedBy,
            isDeleted: $this->isDeleted,
            uuid: $this->uuid,
            createdAt: $this->createdAt,
            updatedAt: new \DateTimeImmutable(),
            id: $this->id,
        );
    }

    public function delete(UserId $deletedBy): self
    {
        return new self(
            name: $this->name,
            description: $this->description,
            imageName: $this->imageName,
            taxRate: $this->taxRate,
            additionalPercentage: $this->additionalPercentage,
            isQuotationEnable: $this->isQuotationEnable,
            order: $this->order,
            createdBy: $this->createdBy,
            updatedBy: $deletedBy,
            isDeleted: true,
            uuid: $this->uuid,
            createdAt: $this->createdAt,
            updatedAt: new \DateTimeImmutable(),
        );
    }
}
