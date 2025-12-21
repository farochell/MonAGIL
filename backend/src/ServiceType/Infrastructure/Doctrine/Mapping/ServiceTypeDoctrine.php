<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Infrastructure\Doctrine\Mapping;

use App\ServiceType\Domain\ValueObject\ServiceTypeUuid;
use App\ServiceType\Infrastructure\Doctrine\Type\ServiceTypeUuidType;
use App\User\Domain\ValueObject\LegacyUserId;
use App\User\Infrastructure\Doctrine\Type\LegacyUserIdType;
use App\User\Infrastructure\Doctrine\Type\UserIdType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'type_intervention')]
class ServiceTypeDoctrine {
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: 'integer')]
    public ?int $id = null;

    #[ORM\Column(name: 'user_created_id', type: LegacyUserIdType::NAME, nullable: true)]
    public LegacyUserId $createdBy;

    #[ORM\Column(name: 'user_updated_id', type: LegacyUserIdType::NAME, nullable: true)]
    public LegacyUserId $updatedBy;

    #[ORM\Column(name: 'nom', type: 'string', length: 255, nullable: false)]
    public string $name;

    #[ORM\Column(name: 'description', type: 'text', nullable: false)]
    public string $description;

    #[ORM\Column(name: 'image_name', type: 'string', nullable: true)]
    public string $imageName;

    #[ORM\Column(name: 'tva', type: 'float', nullable: true)]
    public float $taxRate;

    #[ORM\Column(name: 'pourcentage_ajouter_urgence', type: 'float', nullable: false)]
    public float $additionalPercentage;

    #[ORM\Column(name: 'is_quotation_enabled', type: 'boolean', nullable: false)]
    public bool $isQuotationEnable;

    #[ORM\Column(name: 'is_deleted', type: 'boolean', nullable: false)]
    public bool $isDeleted = false;

    #[ORM\Column(name: 'ordre', type: 'integer', nullable: false)]
    public int $order;

    #[ORM\Column(name: 'uuid', type: ServiceTypeUuidType::NAME)]
    public ServiceTypeUuid $uuid;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    public \DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable', nullable: true)]
    public ?\DateTimeImmutable $updatedAt = null;

}
