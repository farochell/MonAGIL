<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\ArtisanInfo;
use App\User\Domain\Entity\User;

interface ArtisanInfoRepository {
    public function getArtisanInfo(User $user): ?ArtisanInfo;
    public function save(ArtisanInfo $artisanInfo): void;
}
