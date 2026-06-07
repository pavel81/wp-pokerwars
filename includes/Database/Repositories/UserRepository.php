<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Repositories;

use Panda\PokerWars\Database\Contracts\UserRepositoryInterface;
use Panda\PokerWars\DTO\UserDto;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?UserDto
    {
        $table = $this->table('users');

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

    public function findByExternalUser(
        int $externalUserId,
        string $provider
    ): ?UserDto {
        $table = $this->table('users');

        $row = $this->wpdb->get_row(
            $this->wpdb->prepare(
                "SELECT * FROM {$table}
                WHERE external_user_id = %d
                AND provider = %s",
                $externalUserId,
                $provider
            ),
            ARRAY_A
        );

        if (!is_array($row)) {
            return null;
        }

        return $this->mapRowToDto($row);
    }

    /**
     * @param array<string,mixed> $row
     */
    private function mapRowToDto(array $row): UserDto
    {
        return new UserDto(
            id: (int) $row['id'],
            externalUserId: (int) $row['external_user_id'],
            provider: (string) $row['provider'],
            nickname: (string) $row['nickname'],
           avatar: $row['avatar'] !== null
    ? (string) $row['avatar']
    : null,
            status: (string) $row['status']
        );
    }
}
