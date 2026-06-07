<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class BotDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $difficulty,
        public ?string $avatar,
        public bool $isActive,
        public string $createdAt,
        public ?string $updatedAt
    ) {
    }
}
