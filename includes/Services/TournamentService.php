<?php

declare(strict_types=1);

namespace Panda\PokerWars\Services;

use Panda\PokerWars\Database\Contracts\TournamentPlayerRepositoryInterface;
use Panda\PokerWars\Database\Contracts\TournamentRepositoryInterface;
use Panda\PokerWars\Database\Contracts\TransactionManagerInterface;
use Panda\PokerWars\DTO\TournamentDto;
use Panda\PokerWars\DTO\TournamentPlayerDto;

final class TournamentService
{
    public function __construct(
        private readonly TournamentRepositoryInterface $tournaments,
        private readonly TournamentPlayerRepositoryInterface $players,
        private readonly TransactionManagerInterface $transactions
    ) {
    }

    public function createTournament(
        TournamentDto $tournament
    ): int {
        return $this->tournaments->create(
            $tournament
        );
    }

    public function registerPlayer(
        TournamentPlayerDto $player
    ): int {
        return $this->players->create(
            $player
        );
    }

    public function createTournamentWithOwner(
        TournamentDto $tournament,
        TournamentPlayerDto $owner
    ): int {
        return $this->transactions->transactional(
            function () use (
                $tournament,
                $owner
            ): int {
                $tournamentId = $this->tournaments->create(
                    $tournament
                );

                $this->players->create(
                    new TournamentPlayerDto(
                        id: 0,
                        tournamentId: $tournamentId,
                        userId: $owner->userId,
                        joinedAt: $owner->joinedAt,
                        position: null,
                        chips: $owner->chips
                    )
                );

                return $tournamentId;
            }
        );
    }

    public function findTournament(
        int $id
    ): ?TournamentDto {
        return $this->tournaments->findById(
            $id
        );
    }

    /**
     * @return array<TournamentDto>
     */
    public function findAllTournaments(): array
    {
        return $this->tournaments->findAll();
    }

    /**
     * @return array<TournamentPlayerDto>
     */
    public function findTournamentPlayers(
        int $tournamentId
    ): array {
        return $this->players->findByTournament(
            $tournamentId
        );
    }

    public function updateTournament(
        TournamentDto $tournament
    ): bool {
        return $this->tournaments->update(
            $tournament
        );
    }

    public function removeTournament(
        int $id
    ): bool {
        return $this->tournaments->delete(
            $id
        );
    }

    public function removePlayer(
        int $id
    ): bool {
        return $this->players->delete(
            $id
        );
    }
}
