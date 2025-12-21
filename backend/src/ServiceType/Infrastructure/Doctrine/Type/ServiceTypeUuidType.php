<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\Infrastructure\Doctrine\Type;

use App\ServiceType\Domain\ValueObject\ServiceTypeUuid;
use App\Shared\Infrastructure\Doctrine\Type\UuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class ServiceTypeUuidType extends UuidType
{
    public const string NAME = 'service_type_uuid';

    #[Override]
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL([
            'length' => 16,
            'fixed' => true,
        ]);
    }

    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string|null
    {
        if ($value === null) {
            return null;
        }

        return hex2bin(str_replace('-', '', $value->toString()));
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ServiceTypeUuid|null
    {
        if ($value === null) {
            return null;
        }

        $hex = bin2hex($value);
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($hex, 4));
        return ServiceTypeUuid::fromString($uuid);
    }
}
