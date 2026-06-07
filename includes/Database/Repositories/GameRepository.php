<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Repositories;

use Panda\PokerWars\Database\Contracts\GameRepositoryInterface;
use Panda\PokerWars\Database\Exceptions\RepositoryException;
use Panda\PokerWars\DTO\GameDto;

final class GameRepository extends AbstractRepository implements GameRepositoryInterface
{
    public function findById(
        int $id
    ): ?GameDto {
        $table = $this->table('games');

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
     * @return array<GameDto>
     */
    public function findAll(): array
    {
        $table = $this->table('games');

        $rows = $this->wpdb->get_results(
            "SELECT * FROM {$table} ORDER BY id DESC",
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): GameDto => $this->mapRowToDto($row),
            $rows
        );
    }

    /**
     * @return array<GameDto>
     */
    public function findByTournament(
        int $tournamentId
    ): array {
        $table = $this->table('games');

        $rows = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$table}
                 WHERE tournament_id = %d
                 ORDER BY id DESC",
                $tournamentId
            ),
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): GameDto => $this->mapRowToDto($row),
            $rows
        );
    }

    public function create(
        GameDto $game
    ): int {
        $table = $this->table('games');

        $result = $this->wpdb->insert(
            $table,
            [
                'tournament_id' => $game->tournamentId,
                'table_name' => $game->tableName,
                'status' => $game->status,
                'max_players' => $game->maxPlayers,
                'current_players' => $game->currentPlayers,
                'winner_user_id' => $game->winnerUserId,
                'started_at' => $game->startedAt,
                'finished_at' => $game->finishedAt,
            ],
            [
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to create game.'
            );
        }

        return (int) $this->wpdb->insert_id;
    }

    public function update(
        GameDto $game
    ): bool {
        $table = $this->table('games');

        $result = $this->wpdb->update(
            $table,
            [
                'table_name' => $game->tableName,
                'status' => $game->status,
                'max_players' => $game->maxPlayers,
                'current_players' => $game->currentPlayers,
                'winner_user_id' => $game->winnerUserId,
                'started_at' => $game->startedAt,
                'finished_at' => $game->finishedAt,
            ],
            [
                'id' => $game->id,
            ],
            [
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
            ],
            [
                '%d',
            ]
        );

        if ($result === false) {
            throw new RepositoryException(
                'Failed to update game.'
            );
        }

        return true;
    }

    public function delete(
        int $id
    ): bool {
        $table = $this->table('games');

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
                'Failed to delete game.'
            );
        }

        return true;
    }

    /**
     * @param array<string,mixed> $row
     */
    private function mapRowToDto(
        array $row
    ): GameDto {
        return new GameDto(
            id: (int) $row['id'],
            tournamentId: $row['tournament_id'] !== null
                ? (int) $row['tournament_id']
                : null,
            tableName: (string) $row['table_name'],
            status: (string) $row['status'],
            maxPlayers: (int) $row['max_players'],
            currentPlayers: (int) $row['current_players'],
            winnerUserId: $row['winner_user_id'] !== null
                ? (int) $row['winner_user_id']
                : null,
            startedAt: $row['started_at'] !== null
                ? (string) $row['started_at']
                : null,
            finishedAt: $row['finished_at'] !== null
                ? (string) $row['finished_at']
                : null,
            createdAt: (string) $row['created_at'],
            updatedAt: $row['updated_at'] !== null
                ? (string) $row['updated_at']
                : null
        );
    }
}
