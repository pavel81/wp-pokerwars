<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Contracts;

use Panda\PokerWars\DTO\TournamentDto;

interface TournamentRepositoryInterface
{
    public function findById(int $id): ?TournamentDto;

    /**
     * @return array<TournamentDto>
     */
    public function findAll(): array;

    public function create(TournamentDto $tournament): int;

    public function update(TournamentDto $tournament): bool;

    public function delete(int $id): bool;
}
