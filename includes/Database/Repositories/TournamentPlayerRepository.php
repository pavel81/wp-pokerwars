<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Repositories;

use Panda\PokerWars\Database\Contracts\TournamentPlayerRepositoryInterface;
use Panda\PokerWars\Database\Exceptions\RepositoryException;
use Panda\PokerWars\DTO\TournamentPlayerDto;

final class TournamentPlayerRepository
    extends AbstractRepository
    implements TournamentPlayerRepositoryInterface
{
    public function findById(
        int $id
    ): ?TournamentPlayerDto {
        $table = $this->table('tournament_players');

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
     * @return array<TournamentPlayerDto>
     */
    public function findByTournament(
        int $tournamentId
    ): array {
        $table = $this->table('tournament_players');

        $rows = $this->wpdb->get_results(
            $this->wpdb->prepare(
                "SELECT * FROM {$table}
                 WHERE tournament_id = %d",
                $tournamentId
            ),
            ARRAY_A
        );

        if (!is_array($rows)) {
            return [];
        }

        return array_map(
            fn(array $row): TournamentPlayerDto
                => $this->mapRowToDto($row),
            $rows
        );
    }
    public function create(
    TournamentPlayerDto $player
): int {
    $table = $this->table('tournament_players');

    $result = $this->wpdb->insert(
        $table,
        [
            'tournament_id' => $player->tournamentId,
            'user_id' => $player->userId,
            'joined_at' => $player->joinedAt,
            'position' => $player->position,
            'chips' => $player->chips,
        ],
        [
            '%d',
            '%d',
            '%s',
            '%d',
            '%d',
        ]
    );

    if ($result === false) {
        throw new RepositoryException(
            'Failed to create tournament player.'
        );
    }

    return (int) $this->wpdb->insert_id;
}

public function update(
    TournamentPlayerDto $player
): bool {
    $table = $this->table('tournament_players');

    $result = $this->wpdb->update(
        $table,
        [
            'position' => $player->position,
            'chips' => $player->chips,
        ],
        [
            'id' => $player->id,
        ],
        [
            '%d',
            '%d',
        ],
        [
            '%d',
        ]
    );

    if ($result === false) {
        throw new RepositoryException(
            'Failed to update tournament player.'
        );
    }

    return true;
}

public function delete(int $id): bool
{
    $table = $this->table('tournament_players');

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
            'Failed to delete tournament player.'
        );
    }

    return true;
}

/**
 * @param array<string,mixed> $row
 */
private function mapRowToDto(
    array $row
): TournamentPlayerDto {
    return new TournamentPlayerDto(
        id: (int) $row['id'],
        tournamentId: (int) $row['tournament_id'],
        userId: (int) $row['user_id'],
        joinedAt: (string) $row['joined_at'],
        position: $row['position'] !== null
            ? (int) $row['position']
            : null,
        chips: (int) $row['chips']
    );
}
}
