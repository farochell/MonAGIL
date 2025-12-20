<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\DebitCredit;
use App\User\Domain\ValueObject\LegacyUserId;

interface DebitCreditRepository {
    public function save(DebitCredit $debitCredit): void;
    public function getDebitCreditByUserId(LegacyUserId $userId): ?DebitCredit;
}
