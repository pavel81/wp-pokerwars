<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class TournamentPlayerDto
{
    public function __construct(
       public int $id,
       public int $tournamentId,
       public int $userId,
       public string $joinedAt,
       public ?int $position,
       public int $chips
    ) {
    }
}
