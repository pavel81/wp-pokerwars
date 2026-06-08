<?php

declare(strict_types=1);

namespace Panda\PokerWars\Services;

use Panda\PokerWars\Audit\AuditEvents;
use Panda\PokerWars\Database\Contracts\PointsLedgerRepositoryInterface;
use Panda\PokerWars\DTO\PointsLedgerDto;

final class PointsLedgerService
{
    public function __construct(
        private readonly PointsLedgerRepositoryInterface $ledger,
        private readonly AuditService $audit
    ) {
    }

    public function awardPoints(
        PointsLedgerDto $entry
    ): int {
        $entryId = $this->ledger->create(
            $entry
        );

        $this->audit->log(
            AuditEvents::POINTS_AWARDED,
            'info',
            $entry->userId,
            $entry->referenceKey
        );

        return $entryId;
    }

    public function spendPoints(
        PointsLedgerDto $entry
    ): int {
        $entryId = $this->ledger->create(
            $entry
        );

        $this->audit->log(
            AuditEvents::POINTS_SPENT,
            'info',
            $entry->userId,
            $entry->referenceKey
        );

        return $entryId;
    }

    public function getBalance(
        int $userId
    ): int {
        return $this->ledger->getUserBalance(
            $userId
        );
    }

    /**
     * @return array<PointsLedgerDto>
     */
    public function getHistory(
        int $userId
    ): array {
        return $this->ledger->findByUserId(
            $userId
        );
    }

    /**
     * @return array<PointsLedgerDto>
     */
    public function findByReferenceKey(
        string $referenceKey
    ): array {
        return $this->ledger->findByReferenceKey(
            $referenceKey
        );
    }

    public function findEntry(
        int $id
    ): ?PointsLedgerDto {
        return $this->ledger->findById(
            $id
        );
    }
}
