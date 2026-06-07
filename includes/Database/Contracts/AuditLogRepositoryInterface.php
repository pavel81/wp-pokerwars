<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Contracts;

use Panda\PokerWars\DTO\AuditLogDto;

interface AuditLogRepositoryInterface extends RepositoryInterface
{
    public function findById(int $id): ?AuditLogDto;

    /**
     * @return array<AuditLogDto>
     */
    public function findLatest(
        int $limit = 100
    ): array;

    /**
     * @return array<AuditLogDto>
     */
    public function findByUserId(
        int $userId,
        int $limit = 100
    ): array;

    public function create(
        AuditLogDto $log
    ): int;

    public function delete(
        int $id
    ): bool;
}
