<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Repositories;

use Panda\PokerWars\Database\Contracts\UserRewardRepositoryInterface;
use Panda\PokerWars\Database\Exceptions\RepositoryException;
use Panda\PokerWars\DTO\UserRewardDto;

final class UserRewardRepository extends AbstractRepository implements UserRewardRepositoryInterface
{
    public function findById(
        int $id
    ): ?UserRewardDto {
        $table = $this->table('user_rewards');

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
     * @return array<UserRewardDto>
     */
    public function findByUserId(
        int $userId
    ): array {
        $table = $this->table('user_rewards');

        $rows = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$table}
                 WHERE user_id = %d
                 ORDER BY earned_at DESC",
                $userId
            ),
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): UserRewardDto => $this->mapRowToDto($row),
            $rows
        );
    }

    /**
     * @return array<UserRewardDto>
     */
    public function findByRewardId(
        int $rewardId
    ): array {
        $table = $this->table('user_rewards');

        $rows = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$table}
                 WHERE reward_id = %d
                 ORDER BY earned_at DESC",
                $rewardId
            ),
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): UserRewardDto => $this->mapRowToDto($row),
            $rows
        );
    }

    /**
     * @return array<UserRewardDto>
     */
    public function findByStatus(
        string $status
    ): array {
        $table = $this->table('user_rewards');

        $rows = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$table}
                 WHERE status = %s
                 ORDER BY earned_at DESC",
                $status
            ),
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): UserRewardDto => $this->mapRowToDto($row),
            $rows
        );
    }

    public function create(
        UserRewardDto $reward
    ): int {
        $table = $this->table('user_rewards');

        $result = $this->wpdb->insert(
            $table,
            [
                'user_id' => $reward->userId,
                'reward_id' => $reward->rewardId,
                'status' => $reward->status,
                'earned_at' => $reward->earnedAt,
                'claimed_at' => $reward->claimedAt,
                'expires_at' => $reward->expiresAt,
            ],
            [
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to create user reward.'
            );
        }

        return (int) $this->wpdb->insert_id;
    }

    public function update(
        UserRewardDto $reward
    ): bool {
        $table = $this->table('user_rewards');

        $result = $this->wpdb->update(
            $table,
            [
                'status' => $reward->status,
                'claimed_at' => $reward->claimedAt,
                'expires_at' => $reward->expiresAt,
            ],
            [
                'id' => $reward->id,
            ],
            [
                '%s',
                '%s',
                '%s',
            ],
            [
                '%d',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to update user reward.'
            );
        }

        return true;
    }

    public function delete(
        int $id
    ): bool {
        $table = $this->table('user_rewards');

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
                'Failed to delete user reward.'
            );
        }

        return true;
    }

    /**
     * @param array<string,mixed> $row
     */
    private function mapRowToDto(
        array $row
    ): UserRewardDto {
        return new UserRewardDto(
            id: (int) $row['id'],
            userId: (int) $row['user_id'],
            rewardId: (int) $row['reward_id'],
            status: (string) $row['status'],
            earnedAt: (string) $row['earned_at'],
            claimedAt: $row['claimed_at'] !== null
                ? (string) $row['claimed_at']
                : null,
            expiresAt: $row['expires_at'] !== null
                ? (string) $row['expires_at']
                : null
        );
    }
}
