<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Domain\Repository;

use App\ServiceType\Domain\Entity\ServiceType;
use App\ServiceType\Domain\ValueObject\ServiceTypeId;
use App\ServiceType\Domain\ValueObject\ServiceTypes;

interface ServiceTypeRepository
{
    public function findAllServiceTypes(): ServiceTypes;
    public function save(ServiceType $serviceType): ServiceType;

    public function delete(ServiceType $serviceType): void;

    public function findById(ServiceTypeId $id): ?ServiceType;
    public function update(ServiceType $serviceType): ServiceType;
}
