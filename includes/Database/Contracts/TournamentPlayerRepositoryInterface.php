<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Contracts;

use Panda\PokerWars\DTO\TournamentPlayerDto;

interface TournamentPlayerRepositoryInterface extends RepositoryInterface
{
    public function findById(int $id): ?TournamentPlayerDto;

    /**
     * @return array<TournamentPlayerDto>
     */
    public function findByTournament(int $tournamentId): array;

    public function create(
        TournamentPlayerDto $player
    ): int;

    public function update(
        TournamentPlayerDto $player
    ): bool;

    public function delete(int $id): bool;
}
