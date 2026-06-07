<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class RewardDto
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description,
        public ?string $partner,
        public string $rewardType,
        public ?string $rewardValue,
        public int $pointsRequired,
        public bool $isActive,
        public string $createdAt,
        public ?string $updatedAt
    ) {
    }
}
