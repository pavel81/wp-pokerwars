<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Repositories;

use Panda\PokerWars\Database\Contracts\RewardRepositoryInterface;
use Panda\PokerWars\Database\Exceptions\RepositoryException;
use Panda\PokerWars\DTO\RewardDto;

final class RewardRepository extends AbstractRepository implements RewardRepositoryInterface
{
    public function findById(
        int $id
    ): ?RewardDto {
        $table = $this->table('rewards');

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
     * @return array<RewardDto>
     */
    public function findAll(): array
    {
        $table = $this->table('rewards');

        $rows = $this->wpdb->get_results(
            "SELECT * FROM {$table} ORDER BY id DESC",
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): RewardDto => $this->mapRowToDto($row),
            $rows
        );
    }

    /**
     * @return array<RewardDto>
     */
    public function findActive(): array
    {
        $table = $this->table('rewards');

        $rows = $this->wpdb->get_results(
            "SELECT * FROM {$table}
             WHERE is_active = 1
             ORDER BY points_required ASC",
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): RewardDto => $this->mapRowToDto($row),
            $rows
        );
    }

    public function create(
        RewardDto $reward
    ): int {
        $table = $this->table('rewards');

        $result = $this->wpdb->insert(
            $table,
            [
                'name' => $reward->name,
                'description' => $reward->description,
                'partner' => $reward->partner,
                'reward_type' => $reward->rewardType,
                'reward_value' => $reward->rewardValue,
                'points_required' => $reward->pointsRequired,
                'is_active' => $reward->isActive ? 1 : 0,
            ],
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to create reward.'
            );
        }

        return (int) $this->wpdb->insert_id;
    }

    public function update(
        RewardDto $reward
    ): bool {
        $table = $this->table('rewards');

        $result = $this->wpdb->update(
            $table,
            [
                'name' => $reward->name,
                'description' => $reward->description,
                'partner' => $reward->partner,
                'reward_type' => $reward->rewardType,
                'reward_value' => $reward->rewardValue,
                'points_required' => $reward->pointsRequired,
                'is_active' => $reward->isActive ? 1 : 0,
            ],
            [
                'id' => $reward->id,
            ],
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
            ],
            [
                '%d',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to update reward.'
            );
        }

        return true;
    }

    public function delete(
        int $id
    ): bool {
        $table = $this->table('rewards');

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
                'Failed to delete reward.'
            );
        }

        return true;
    }

    /**
     * @param array<string,mixed> $row
     */
    private function mapRowToDto(
        array $row
    ): RewardDto {
        return new RewardDto(
            id: (int) $row['id'],
            name: (string) $row['name'],
            description: $row['description'] !== null
                ? (string) $row['description']
                : null,
            partner: $row['partner'] !== null
                ? (string) $row['partner']
                : null,
            rewardType: (string) $row['reward_type'],
            rewardValue: $row['reward_value'] !== null
                ? (string) $row['reward_value']
                : null,
            pointsRequired: (int) $row['points_required'],
            isActive: (bool) $row['is_active'],
            createdAt: (string) $row['created_at'],
            updatedAt: $row['updated_at'] !== null
                ? (string) $row['updated_at']
                : null
        );
    }
}
