<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Repositories;

use Panda\PokerWars\Database\Contracts\TournamentRepositoryInterface;
use Panda\PokerWars\Database\Exceptions\RepositoryException;
use Panda\PokerWars\DTO\TournamentDto;

final class TournamentRepository extends AbstractRepository implements TournamentRepositoryInterface
{
    public function findById(int $id): ?TournamentDto
    {
        $table = $this->table('tournaments');

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
     * @return array<TournamentDto>
     */
    public function findAll(): array
    {
        $table = $this->table('tournaments');

        $rows = $this->wpdb->get_results(
            "SELECT * FROM {$table} ORDER BY id DESC",
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): TournamentDto => $this->mapRowToDto($row),
            $rows
        );
    }

   public function create(TournamentDto $tournament): int
{
    $table = $this->table('tournaments');

    $result = $this->wpdb->insert(
        $table,
        [
            'name' => $tournament->name,
            'status' => $tournament->status,
            'buy_in' => (string) $tournament->buyIn,
            'max_players' => $tournament->maxPlayers,
            'starts_at' => $tournament->startsAt,
            'ends_at' => $tournament->endsAt,
            'winner_user_id' => $tournament->winnerUserId,
        ],
        [
            '%s',
            '%s',
            '%s',
            '%d',
            '%s',
            '%s',
            '%d',
        ]
    );

    if ($result === false) {
        throw new RepositoryException(
            'Failed to create tournament.'
        );
    }

    return (int) $this->wpdb->insert_id;
}

  public function update(TournamentDto $tournament): bool
{
    $table = $this->table('tournaments');

    $result = $this->wpdb->update(
        $table,
        [
            'name' => $tournament->name,
            'status' => $tournament->status,
            'buy_in' =>  $tournament->buyIn,
            'max_players' => $tournament->maxPlayers,
            'starts_at' => $tournament->startsAt,
            'ends_at' => $tournament->endsAt,
            'winner_user_id' => $tournament->winnerUserId,
        ],
        [
            'id' => $tournament->id,
        ],
        [
            '%s',
            '%s',
            '%s',
            '%d',
            '%s',
            '%s',
            '%d',
        ],
        [
            '%d',
        ]
    );

    return $result !== false;
}


 public function delete(int $id): bool
{
    $table = $this->table('tournaments');

    $result = $this->wpdb->delete(
        $table,
        [
            'id' => $id,
        ],
        [
            '%d',
        ]
    );

    return $result !== false;
}


 private function mapRowToDto(array $row): TournamentDto
{
    return new TournamentDto(
        id: (int) $row['id'],
        name: (string) $row['name'],
        status: (string) $row['status'],
        buyIn: $row['buy_in'],
        maxPlayers: (int) $row['max_players'],
        startsAt: $row['starts_at'] !== null
            ? (string) $row['starts_at']
            : null,
        endsAt: $row['ends_at'] !== null
            ? (string) $row['ends_at']
            : null,
        winnerUserId: $row['winner_user_id'] !== null
            ? (int) $row['winner_user_id']
            : null,
        createdAt: (string) $row['created_at'],
        updatedAt: $row['updated_at'] !== null
            ? (string) $row['updated_at']
            : null
    );
}
}
