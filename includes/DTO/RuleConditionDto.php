<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class RuleConditionDto
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description,
        public string $conditionsJson,
        public bool $isActive,
        public string $createdAt,
        public ?string $updatedAt
    ) {
    }
}
