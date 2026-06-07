<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class UserRewardDto
{
    public function __construct(
        public int $id,
        public int $userId,
        public int $rewardId,
        public string $status,
        public string $earnedAt,
        public ?string $claimedAt,
        public ?string $expiresAt
    ) {
    }
}
