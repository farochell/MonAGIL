<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Application\CreateServiceType;

use App\ServiceType\Application\Response\ServiceTypeResponse;
use App\ServiceType\Domain\Entity\ServiceType;
use App\ServiceType\Domain\Repository\ServiceTypeRepository;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\User\Domain\ValueObject\LegacyUserId;

class CreateServiceTypeCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ServiceTypeRepository $serviceTypeRepository
    ) {}

    public function __invoke(CreateServiceTypeCommand $command): ServiceTypeResponse {
        $serviceType = ServiceType::create(
            $command->name,
            $command->description,
            $command->imageName,
            $command->taxRate,
            $command->additionalPercentage,
            $command->isQuotationEnable,
            $command->order,
            LegacyUserId::fromInt($command->createdBy)
        );
        $serviceType = $this->serviceTypeRepository->save($serviceType);
        return ServiceTypeResponse::fromEntity($serviceType);
    }
}
