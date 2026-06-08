<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Repositories;

use Panda\PokerWars\Database\Contracts\PointsLedgerRepositoryInterface;
use Panda\PokerWars\Database\Exceptions\RepositoryException;
use Panda\PokerWars\DTO\PointsLedgerDto;

final class PointsLedgerRepository extends AbstractRepository implements PointsLedgerRepositoryInterface
{
    public function findById(
        int $id
    ): ?PointsLedgerDto {
        $table = $this->table('points_ledger');

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
     * @return array<PointsLedgerDto>
     */
    public function findByUserId(
        int $userId
    ): array {
        $table = $this->table('points_ledger');

        $rows = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$table}
                 WHERE user_id = %d
                 ORDER BY created_at DESC",
                $userId
            ),
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): PointsLedgerDto
                => $this->mapRowToDto($row),
            $rows
        );
    }

    /**
     * @return array<PointsLedgerDto>
     */
    public function findByReferenceKey(
        string $referenceKey
    ): array {
        $table = $this->table('points_ledger');

        $rows = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$table}
                 WHERE reference_key = %s",
                $referenceKey
            ),
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): PointsLedgerDto
                => $this->mapRowToDto($row),
            $rows
        );
    }

    public function create(
        PointsLedgerDto $entry
    ): int {
        $table = $this->table('points_ledger');

        $exists = $this->wpdb->get_var(
            $this->wpdb->prepare(
                "SELECT COUNT(*)
                 FROM {$table}
                 WHERE reference_key = %s",
                $entry->referenceKey
            )
        );

        if ((int) $exists > 0) {
            throw new RepositoryException(
                'Reference key already exists.'
            );
        }

        $result = $this->wpdb->insert(
            $table,
            [
                'user_id' => $entry->userId,
                'source_type' => $entry->sourceType,
                'source_id' => $entry->sourceId,
                'reference_key' => $entry->referenceKey,
                'points' => $entry->points,
                'description' => $entry->description,
            ],
            [
                '%d',
                '%s',
                '%d',
                '%s',
                '%d',
                '%s',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to create points ledger entry.'
            );
        }

        return (int) $this->wpdb->insert_id;
    }

    public function delete(
        int $id
    ): bool {
        $table = $this->table('points_ledger');

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
                'Failed to delete points ledger entry.'
            );
        }

        return true;
    }

    public function getUserBalance(
        int $userId
    ): int {
        $table = $this->table('points_ledger');

        $result = $this->wpdb->get_var(
            $this->wpdb->prepare(
                "SELECT COALESCE(SUM(points), 0)
                 FROM {$table}
                 WHERE user_id = %d",
                $userId
            )
        );

        return (int) $result;
    }

    /**
     * @param array<string,mixed> $row
     */
    private function mapRowToDto(
        array $row
    ): PointsLedgerDto {
        return new PointsLedgerDto(
            id: (int) $row['id'],
            userId: (int) $row['user_id'],
            sourceType: (string) $row['source_type'],
            sourceId: (int) $row['source_id'],
            referenceKey: (string) $row['reference_key'],
            points: (int) $row['points'],
            description: $row['description'] !== null
                ? (string) $row['description']
                : null,
            createdAt: (string) $row['created_at']
        );
    }
}
