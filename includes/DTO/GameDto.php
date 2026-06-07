<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class GameDto
{
    public function __construct(
        public int $id,
        public ?int $tournamentId,
        public string $tableName,
        public string $status,
        public int $maxPlayers,
        public int $currentPlayers,
        public ?int $winnerUserId,
        public ?string $startedAt,
        public ?string $finishedAt,
        public string $createdAt,
        public ?string $updatedAt
    ) {
    }
}
