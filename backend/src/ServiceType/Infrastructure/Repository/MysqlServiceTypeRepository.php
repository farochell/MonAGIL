<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Infrastructure\Repository;

use App\ServiceType\Domain\Entity\ServiceType;
use App\ServiceType\Domain\Repository\ServiceTypeRepository;
use App\ServiceType\Infrastructure\Doctrine\Mapping\ServiceTypeDoctrine;
use App\ServiceType\Domain\ValueObject\ServiceTypeId;
use App\ServiceType\Domain\ValueObject\ServiceTypes;
use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Shared\Infrastructure\Repository\BaseRepository;
use App\User\Domain\ValueObject\LegacyUserId;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use stdClass;
use Throwable;
use function Lambdish\Phunctional\map;

class MysqlServiceTypeRepository
    extends BaseRepository
    implements ServiceTypeRepository {
    public function __construct(
        ManagerRegistry $managerRegistry,
        LoggerInterface $logger
    ) {
        parent::__construct(
            $managerRegistry,
            ServiceTypeDoctrine::class,
            'ServiceType',
            $logger
        );
    }

    public function findAllServiceTypes(): ServiceTypes {
        try {
            $serviceTypes = $this->getEntityManager()
                ->getRepository(ServiceTypeDoctrine::class)->findBy([
                    'isDeleted' => false
                ]);
            $formattedServiceTypes = map(
                fn(ServiceTypeDoctrine $serviceType) => $this->transformEntity($serviceType),
                $serviceTypes
            );
            return new ServiceTypes($formattedServiceTypes);
        } catch (Throwable $e) {
            $exception = EntityNotFoundException::fromPrevious($this->entityName, $e);
            $this->logAndThrowException(
                $exception,
                new stdClass(),
                [
                    'action' => 'findAll'
                ]
            );
        }
    }

    public function save(ServiceType $serviceType): ServiceType {
        try {
            $entity = $this->toDoctrineEntity($serviceType);
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
            return $this->transformEntity($entity);
        } catch (Throwable $e) {
            $exception = EntityNotFoundException::fromPrevious($this->entityName, $e);
            $this->logAndThrowException(
                $exception,
                $serviceType,
                [
                    'action' => 'save',
                    'data' => $this->serializeEntity($serviceType)
                ]
            );
        }
    }

    public function delete(ServiceType $serviceType): void {
        try {
            if ($serviceType->id === null) {
                throw new \InvalidArgumentException('Cannot delete entity without ID');
            }

            $doctrineServiceType = $this->getEntityManager()
                ->getRepository(ServiceTypeDoctrine::class)
                ->find($serviceType->id->value());

            if ($doctrineServiceType) {
                $doctrineServiceType->isDeleted = true;
                $doctrineServiceType->updatedBy = $serviceType->updatedBy;
                $doctrineServiceType->updatedAt = new \DateTimeImmutable();

                $this->getEntityManager()->persist($doctrineServiceType);
                $this->getEntityManager()->flush();
            }
        } catch (Throwable $e) {
            $exception = EntityNotFoundException::fromPrevious($this->entityName, $e);
            $this->logAndThrowException(
                $exception,
                $serviceType,
                [
                    'action' => 'delete'
                ]
            );
        }
    }

    public function findById(ServiceTypeId $id): ?ServiceType {
        try {
            $doctrineServiceType = $this->getEntityManager()
                ->getRepository(ServiceTypeDoctrine::class)
                ->find($id->value());

            return $doctrineServiceType ? $this->transformEntity($doctrineServiceType) : null;
        } catch (Throwable $e) {
            $exception = EntityNotFoundException::fromPrevious($this->entityName, $e);
            $this->logAndThrowException(
                $exception,
                new stdClass(),
                [
                    'action' => 'findById',
                    'id' => $id->value()
                ]
            );
        }
    }

    public function update(ServiceType $serviceType): ServiceType {
        try {
            if ($serviceType->id === null) {
                throw new \InvalidArgumentException('Cannot update entity without ID');
            }

            $doctrineServiceType = $this->toDoctrineEntity($serviceType);

            $this->getEntityManager()->persist($doctrineServiceType);
            $this->getEntityManager()->flush();
            return $this->transformEntity($doctrineServiceType);
        } catch (Throwable $e) {
            $exception = EntityNotFoundException::fromPrevious($this->entityName, $e);
            $this->logAndThrowException(
                $exception,
                $serviceType,
                [
                    'action' => 'update',
                    'data' => $this->serializeEntity($serviceType)
                ]
            );
        }
    }

    private function transformEntity(
        ServiceTypeDoctrine $serviceType
    ): ServiceType {
        return new ServiceType(
            $serviceType->name,
            $serviceType->description,
            $serviceType->additionalPercentage,
            $serviceType->isQuotationEnable,
            $serviceType->order,
            $serviceType->imageName ?? null,
            $serviceType->taxRate ?? null,
            $serviceType->createdBy ?? null,
            $serviceType->updatedBy ?? null,
            $serviceType->isDeleted ?? false,
            $serviceType->uuid ?? null,
            $serviceType->createdAt ?? null,
            $serviceType->updatedAt ?? null,
            ServiceTypeId::fromInt($serviceType->id)
        );
    }

    private function toDoctrineEntity(
        ServiceType $serviceType
    ): ServiceTypeDoctrine  {
        if ($serviceType->id !== null) {
            $doctrineServiceType = $this->getEntityManager()
                ->getRepository(ServiceTypeDoctrine::class)
                ->find($serviceType->id->value());

            if (!$doctrineServiceType) {
                throw new EntityNotFoundException(
                    sprintf('ServiceTypeDoctrine with ID %s not found',
                        $serviceType->id->value()
                    )
                );
            }
        } else {
            $doctrineServiceType = new ServiceTypeDoctrine();
        }

        $doctrineServiceType->name = $serviceType->name;
        $doctrineServiceType->description = $serviceType->description;
        $doctrineServiceType->additionalPercentage = $serviceType->additionalPercentage;
        $doctrineServiceType->isQuotationEnable = $serviceType->isQuotationEnable;
        $doctrineServiceType->order = $serviceType->order;
        $doctrineServiceType->imageName = $serviceType->imageName;
        $doctrineServiceType->taxRate = $serviceType->taxRate;
        $doctrineServiceType->createdBy = $serviceType->createdBy;
        $doctrineServiceType->updatedBy = $serviceType->updatedBy;
        $doctrineServiceType->isDeleted = $serviceType->isDeleted;
        $doctrineServiceType->uuid = $serviceType->uuid;
        $doctrineServiceType->createdAt = $serviceType->createdAt;
        $doctrineServiceType->updatedAt = $serviceType->updatedAt;

        return $doctrineServiceType;
    }
}
