<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class PointsLedgerDto
{
    public function __construct(
        public int $id,
        public int $userId,
        public string $sourceType,
        public int $sourceId,
        public string $referenceKey,
        public int $points,
        public ?string $description,
        public string $createdAt
    ) {
    }
}
