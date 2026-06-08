<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Contracts;

use Panda\PokerWars\DTO\PointsLedgerDto;

interface PointsLedgerRepositoryInterface extends RepositoryInterface
{
    public function findById(
        int $id
    ): ?PointsLedgerDto;

    /**
     * @return array<PointsLedgerDto>
     */
    public function findByUserId(
        int $userId
    ): array;

    /**
     * @return array<PointsLedgerDto>
     */
    public function findByReferenceKey(
        string $referenceKey
    ): array;

    public function create(
        PointsLedgerDto $entry
    ): int;

    public function delete(
        int $id
    ): bool;

    public function getUserBalance(
        int $userId
    ): int;
}
