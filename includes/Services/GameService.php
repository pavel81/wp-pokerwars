<?php

declare(strict_types=1);

namespace Panda\PokerWars\Services;

use Panda\PokerWars\Audit\AuditEvents;
use Panda\PokerWars\Database\Contracts\GameRepositoryInterface;
use Panda\PokerWars\DTO\GameDto;

final class GameService
{
    public function __construct(
        private readonly GameRepositoryInterface $games,
        private readonly AuditService $audit
    ) {
    }

    public function createGame(
        GameDto $game
    ): int {
        $gameId = $this->games->create(
            $game
        );

        $this->audit->log(
            AuditEvents::GAME_CREATED,
            'info'
        );

        return $gameId;
    }

    public function updateGame(
        GameDto $game
    ): bool {
        $result = $this->games->update(
            $game
        );

        if ($result) {
            $this->audit->log(
                AuditEvents::GAME_UPDATED,
                'info'
            );
        }

        return $result;
    }

    public function startGame(
        GameDto $game
    ): bool {
        $updatedGame = new GameDto(
            id: $game->id,
            tournamentId: $game->tournamentId,
            tableName: $game->tableName,
            status: 'started',
            maxPlayers: $game->maxPlayers,
            currentPlayers: $game->currentPlayers,
            winnerUserId: $game->winnerUserId,
            startedAt: gmdate('Y-m-d H:i:s'),
            finishedAt: null,
            createdAt: $game->createdAt,
            updatedAt: gmdate('Y-m-d H:i:s')
        );

        $result = $this->games->update(
            $updatedGame
        );

        if ($result) {
            $this->audit->log(
                AuditEvents::GAME_STARTED,
                'info'
            );
        }

        return $result;
    }

    public function finishGame(
        GameDto $game,
        int $winnerUserId
    ): bool {
        $updatedGame = new GameDto(
            id: $game->id,
            tournamentId: $game->tournamentId,
            tableName: $game->tableName,
            status: 'finished',
            maxPlayers: $game->maxPlayers,
            currentPlayers: $game->currentPlayers,
            winnerUserId: $winnerUserId,
            startedAt: $game->startedAt,
            finishedAt: gmdate('Y-m-d H:i:s'),
            createdAt: $game->createdAt,
            updatedAt: gmdate('Y-m-d H:i:s')
        );

        $result = $this->games->update(
            $updatedGame
        );

        if ($result) {
            $this->audit->log(
                AuditEvents::GAME_FINISHED,
                'info',
                $winnerUserId
            );
        }

        return $result;
    }

    public function removeGame(
        int $id
    ): bool {
        $result = $this->games->delete(
            $id
        );

        if ($result) {
            $this->audit->log(
                AuditEvents::GAME_DELETED,
                'warning'
            );
        }

        return $result;
    }

    public function findGame(
        int $id
    ): ?GameDto {
        return $this->games->findById(
            $id
        );
    }

    /**
     * @return array<GameDto>
     */
    public function findAllGames(): array
    {
        return $this->games->findAll();
    }

    /**
     * @return array<GameDto>
     */
    public function findTournamentGames(
        int $tournamentId
    ): array {
        return $this->games->findByTournament(
            $tournamentId
        );
    }
}
