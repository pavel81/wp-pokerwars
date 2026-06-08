<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Repositories;

use Panda\PokerWars\Database\Contracts\PointRuleRepositoryInterface;
use Panda\PokerWars\Database\Exceptions\RepositoryException;
use Panda\PokerWars\DTO\PointRuleDto;

final class PointRuleRepository extends AbstractRepository implements PointRuleRepositoryInterface
{
    public function findById(
        int $id
    ): ?PointRuleDto {
        $table = $this->table('point_rules');

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

    public function findByEventType(
        string $eventType
    ): ?PointRuleDto {
        $table = $this->table('point_rules');

        $row = $this->wpdb->get_row(
            $this->wpdb->prepare(
                "SELECT * FROM {$table}
                 WHERE event_type = %s",
                $eventType
            ),
            ARRAY_A
        );

        if (!is_array($row)) {
            return null;
        }

        return $this->mapRowToDto($row);
    }

    /**
     * @return array<PointRuleDto>
     */
    public function findAll(): array
    {
        $table = $this->table('point_rules');

        $rows = $this->wpdb->get_results(
            "SELECT * FROM {$table} ORDER BY id DESC",
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): PointRuleDto => $this->mapRowToDto($row),
            $rows
        );
    }

    /**
     * @return array<PointRuleDto>
     */
    public function findEnabled(): array
    {
        $table = $this->table('point_rules');

        $rows = $this->wpdb->get_results(
            "SELECT * FROM {$table}
             WHERE enabled = 1",
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): PointRuleDto => $this->mapRowToDto($row),
            $rows
        );
    }

    public function create(
        PointRuleDto $rule
    ): int {
        $table = $this->table('point_rules');

        $result = $this->wpdb->insert(
            $table,
            [
                'event_type' => $rule->eventType,
                'rule_name' => $rule->ruleName,
                'points' => $rule->points,
                'enabled' => $rule->enabled ? 1 : 0,
                'conditions_json' => $rule->conditionsJson,
                'valid_from' => $rule->validFrom,
                'valid_until' => $rule->validUntil,
            ],
            [
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to create point rule.'
            );
        }

        return (int) $this->wpdb->insert_id;
    }

    public function update(
        PointRuleDto $rule
    ): bool {
        $table = $this->table('point_rules');

        $result = $this->wpdb->update(
            $table,
            [
                'rule_name' => $rule->ruleName,
                'points' => $rule->points,
                'enabled' => $rule->enabled ? 1 : 0,
                'conditions_json' => $rule->conditionsJson,
                'valid_from' => $rule->validFrom,
                'valid_until' => $rule->validUntil,
            ],
            [
                'id' => $rule->id,
            ],
            [
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
            ],
            [
                '%d',
            ]
        );

        return $result !== false;
    }

    public function delete(
        int $id
    ): bool {
        $table = $this->table('point_rules');

        return $this->wpdb->delete(
            $table,
            ['id' => $id],
            ['%d']
        ) !== false;
    }

    /**
     * @param array<string,mixed> $row
     */
    private function mapRowToDto(
        array $row
    ): PointRuleDto {
        return new PointRuleDto(
            id: (int) $row['id'],
            eventType: (string) $row['event_type'],
            ruleName: (string) $row['rule_name'],
            points: (int) $row['points'],
            enabled: (bool) $row['enabled'],
            conditionsJson: $row['conditions_json'] !== null
                ? (string) $row['conditions_json']
                : null,
            validFrom: $row['valid_from'] !== null
                ? (string) $row['valid_from']
                : null,
            validUntil: $row['valid_until'] !== null
                ? (string) $row['valid_until']
                : null,
            createdAt: (string) $row['created_at'],
            updatedAt: $row['updated_at'] !== null
                ? (string) $row['updated_at']
                : null
        );
    }
}
