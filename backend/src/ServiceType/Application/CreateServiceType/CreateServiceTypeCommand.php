<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Application\CreateServiceType;

use App\Shared\Domain\Bus\Command\Command;

class CreateServiceTypeCommand implements Command
{
    public function __construct(
        public string $name,
        public string $description,
        public string $imageName,
        public float $taxRate,
        public float $additionalPercentage,
        public bool $isQuotationEnable,
        public int $order,
        public int $createdBy,
    ) {}
}
