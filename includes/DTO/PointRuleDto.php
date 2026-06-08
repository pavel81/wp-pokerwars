<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class PointRuleDto
{
    public function __construct(
        public int $id,
        public string $eventType,
        public string $ruleName,
        public int $points,
        public bool $enabled,
        public ?string $conditionsJson,
        public ?string $validFrom,
        public ?string $validUntil,
        public string $createdAt,
        public ?string $updatedAt
    ) {
    }
}
