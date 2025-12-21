<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Application\Response;

use App\ServiceType\Domain\Entity\ServiceType;
use App\Shared\Application\SerializableResponse;
use App\Shared\Domain\Bus\Command\CommandResponse;

class ServiceTypeResponse extends SerializableResponse implements CommandResponse {
    public function __construct(
        public string $name,
        public string $description,
        public float $additionalPercentage,
        public bool $isQuotationEnable,
        public int $order,
        public ?string $imageName = null,
        public ?float $taxRate = null,
        public ?string $uuid = null,
        public ?\DateTimeImmutable $createdAt = null,
        public ?\DateTimeImmutable $updatedAt = null,
        public ?int $id = null,
        public ?bool $isDeleted = false,
    ) {}

    public static function fromDomain(ServiceType $serviceType): self {
        return new self(
            name: $serviceType->name,
            description: $serviceType->description,
            additionalPercentage: $serviceType->additionalPercentage,
            isQuotationEnable: $serviceType->isQuotationEnable,
            order: $serviceType->order,
            imageName: $serviceType->imageName,
            taxRate: $serviceType->taxRate,
            uuid: $serviceType->uuid->value(),
            createdAt: $serviceType->createdAt,
            updatedAt: $serviceType->updatedAt,
            id: $serviceType->id->value(),
            isDeleted: $serviceType->isDeleted,
        );
    }

    public function jsonSerialize(): array {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'additionalPercentage' => $this->additionalPercentage,
            'isQuotationEnable' => $this->isQuotationEnable,
            'order' => $this->order,
            'imageName' => $this->imageName,
            'taxRate' => $this->taxRate,
            'uuid' => $this->uuid,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'id' => $this->id,
            'isDeleted' => $this->isDeleted,
        ];
    }
}
