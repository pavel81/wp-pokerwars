<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Repositories;

use Panda\PokerWars\Database\Contracts\BotRepositoryInterface;
use Panda\PokerWars\Database\Exceptions\RepositoryException;
use Panda\PokerWars\DTO\BotDto;

final class BotRepository extends AbstractRepository implements BotRepositoryInterface
{
    public function findById(int $id): ?BotDto
    {
        $table = $this->table('bots');

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
     * @return array<BotDto>
     */
    public function findAll(): array
    {
        $table = $this->table('bots');

        $rows = $this->wpdb->get_results(
            "SELECT * FROM {$table} ORDER BY id DESC",
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): BotDto => $this->mapRowToDto($row),
            $rows
        );
    }

    public function create(BotDto $bot): int
    {
        $table = $this->table('bots');

        $result = $this->wpdb->insert(
            $table,
            [
                'name' => $bot->name,
                'difficulty' => $bot->difficulty,
                'avatar' => $bot->avatar,
                'is_active' => $bot->isActive ? 1 : 0,
            ],
            [
                '%s',
                '%s',
                '%s',
                '%d',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to create bot.'
            );
        }

        return (int) $this->wpdb->insert_id;
    }

    public function update(BotDto $bot): bool
    {
        $table = $this->table('bots');

        $result = $this->wpdb->update(
            $table,
            [
                'name' => $bot->name,
                'difficulty' => $bot->difficulty,
                'avatar' => $bot->avatar,
                'is_active' => $bot->isActive ? 1 : 0,
            ],
            [
                'id' => $bot->id,
            ],
            [
                '%s',
                '%s',
                '%s',
                '%d',
            ],
            [
                '%d',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to update bot.'
            );
        }

        return true;
    }

    public function delete(int $id): bool
    {
        $table = $this->table('bots');

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
                'Failed to delete bot.'
            );
        }

        return true;
    }

    /**
     * @param array<string,mixed> $row
     */
    private function mapRowToDto(array $row): BotDto
    {
        return new BotDto(
            id: (int) $row['id'],
            name: (string) $row['name'],
            difficulty: (string) $row['difficulty'],
            avatar: $row['avatar'] !== null
                ? (string) $row['avatar']
                : null,
            isActive: (bool) $row['is_active'],
            createdAt: (string) $row['created_at'],
            updatedAt: $row['updated_at'] !== null
                ? (string) $row['updated_at']
                : null
        );
    }
}
