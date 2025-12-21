<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Application\GetServiceTypes;

use App\ServiceType\Application\Response\ServiceTypesResponse;
use App\ServiceType\Domain\Repository\ServiceTypeRepository;
use App\Shared\Domain\Bus\Query\QueryHandler;

class GetServiceTypesQueryHandler implements QueryHandler {
    public function __construct(
        private readonly ServiceTypeRepository $serviceTypeRepository
    ) {}

    public function __invoke(GetServiceTypesQuery $query): ServiceTypesResponse {
        $serviceTypes = $this->serviceTypeRepository->findAllServiceTypes();

        return ServiceTypesResponse::fromDomain($serviceTypes);
    }
}
