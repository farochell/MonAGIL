<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Domain\ValueObject;

use App\ServiceType\Domain\Entity\ServiceType;
use App\Shared\Domain\Collection;

/*
 * Collection<ServiceTypeDoctrine>
 */
class ServiceTypes  extends Collection  {
    protected function type(): string {
        return ServiceType::class;
    }
}
