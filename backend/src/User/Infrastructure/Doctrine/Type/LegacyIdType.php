<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Type;

use App\User\Domain\ValueObject\LegacyUserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

class LegacyIdType extends IntegerType
{
    public const string TYPE = 'legacy_id';

    public function convertToPHPValue($value, AbstractPlatform $platform) : ?int
    {
        return LegacyUserId::fromInt($value)->value() ?? null;
    }
}
