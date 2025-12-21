<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Application\Response;

use App\ServiceType\Domain\Entity\ServiceType;
use App\ServiceType\Domain\ValueObject\ServiceTypes;
use App\Shared\Application\SerializableResponse;
use App\Shared\Domain\Bus\Query\QueryResponse;
use function Lambdish\Phunctional\map;

class ServiceTypesResponse extends SerializableResponse implements QueryResponse{
    public function __construct(
        public ServiceTypes $serviceTypes
    ) {}

    public static function fromDomain(ServiceTypes $serviceTypes): self
    {
        return new self(
            $serviceTypes
        );
    }

    public function jsonSerialize(): array {
        return map(
            static fn(ServiceType $serviceType): ServiceTypeResponse => ServiceTypeResponse::fromDomain($serviceType),
           $this->serviceTypes
        );
    }
}
