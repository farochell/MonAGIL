<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\PersonalInfo;
use App\User\Domain\Entity\User;

interface PersonalInfoRepository {
    public function save(PersonalInfo $personalInfo): void;
    public function getPropertyManagerInfo(User $user): ?PersonalInfo;
}
