<?php

declare(strict_types=1);

namespace Panda\PokerWars\Services;

use Panda\PokerWars\Database\Contracts\AuditLogRepositoryInterface;
use Panda\PokerWars\DTO\AuditLogDto;

final class AuditService
{
    public function __construct(
        private readonly AuditLogRepositoryInterface $auditLogs
    ) {
    }

    public function log(
        string $eventType,
        string $severity = 'info',
        ?int $userId = null,
        ?string $payload = null
    ): int {
        return $this->auditLogs->create(
            new AuditLogDto(
                id: 0,
                userId: $userId,
                eventType: $eventType,
                severity: $severity,
                payload: $payload,
                createdAt: gmdate('Y-m-d H:i:s')
            )
        );
    }

    /**
     * @return array<AuditLogDto>
     */
    public function latest(
        int $limit = 100
    ): array {
        return $this->auditLogs->findLatest(
            $limit
        );
    }

    /**
     * @return array<AuditLogDto>
     */
    public function userHistory(
        int $userId,
        int $limit = 100
    ): array {
        return $this->auditLogs->findByUserId(
            $userId,
            $limit
        );
    }
}
