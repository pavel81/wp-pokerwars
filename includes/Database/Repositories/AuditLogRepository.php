<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Repositories;

use Panda\PokerWars\Database\Contracts\AuditLogRepositoryInterface;
use Panda\PokerWars\Database\Exceptions\RepositoryException;
use Panda\PokerWars\DTO\AuditLogDto;

final class AuditLogRepository extends AbstractRepository implements AuditLogRepositoryInterface
{
    public function findById(int $id): ?AuditLogDto
    {
        $table = $this->table('audit_log');

        $row = $this->wpdb->get_row(
            $this->wpdb->prepare(
                "SELECT * FROM {$table} WHERE id = %d",
                $id
            ),
            ARRAY_A
        );

        if (!is_array($row)) {
            return null;
        }

        return $this->mapRowToDto($row);
    }

    /**
     * @return array<AuditLogDto>
     */
    public function findLatest(
        int $limit = 100
    ): array {
        $table = $this->table('audit_log');

        $rows = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$table}
                 ORDER BY created_at DESC
                 LIMIT %d",
                $limit
            ),
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): AuditLogDto
                => $this->mapRowToDto($row),
            $rows
        );
    }

    /**
     * @return array<AuditLogDto>
     */
    public function findByUserId(
        int $userId,
        int $limit = 100
    ): array {
        $table = $this->table('audit_log');

        $rows = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$table}
                 WHERE user_id = %d
                 ORDER BY created_at DESC
                 LIMIT %d",
                $userId,
                $limit
            ),
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): AuditLogDto
                => $this->mapRowToDto($row),
            $rows
        );
    }

    public function create(
        AuditLogDto $log
    ): int {
        $table = $this->table('audit_log');

        $result = $this->wpdb->insert(
            $table,
            [
                'user_id' => $log->userId,
                'event_type' => $log->eventType,
                'severity' => $log->severity,
                'payload' => $log->payload,
            ],
            [
                '%d',
                '%s',
                '%s',
                '%s',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to create audit log.'
            );
        }

        return (int) $this->wpdb->insert_id;
    }

    public function delete(
        int $id
    ): bool {
        $table = $this->table('audit_log');

        $result = $this->wpdb->delete(
            $table,
            [
                'id' => $id,
            ],
            [
                '%d',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to delete audit log.'
            );
        }

        return true;
    }

    /**
     * @param array<string,mixed> $row
     */
    private function mapRowToDto(
        array $row
    ): AuditLogDto {
        return new AuditLogDto(
            id: (int) $row['id'],
            userId: $row['user_id'] !== null
                ? (int) $row['user_id']
                : null,
            eventType: (string) $row['event_type'],
            severity: (string) $row['severity'],
            payload: $row['payload'] !== null
                ? (string) $row['payload']
                : null,
            createdAt: (string) $row['created_at']
        );
    }
}
