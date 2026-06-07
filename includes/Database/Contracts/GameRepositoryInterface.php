<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Contracts;

use Panda\PokerWars\DTO\GameDto;

interface GameRepositoryInterface extends RepositoryInterface
{
    public function findById(
        int $id
    ): ?GameDto;

    /**
     * @return array<GameDto>
     */
    public function findAll(): array;

    /**
     * @return array<GameDto>
     */
    public function findByTournament(
        int $tournamentId
    ): array;

    public function create(
        GameDto $game
    ): int;

    public function update(
        GameDto $game
    ): bool;

    public function delete(
        int $id
    ): bool;
}
