<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class TournamentDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $status,
        public string $buyIn,
        public int $maxPlayers,
        public ?string $startsAt,
        public ?string $endsAt,
        public ?int $winnerUserId,
        public string $createdAt,
        public ?string $updatedAt
    ) {
    }
}
