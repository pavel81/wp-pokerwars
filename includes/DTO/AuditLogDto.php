<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class AuditLogDto
{
    public function __construct(
        public int $id,
        public ?int $userId,
        public string $eventType,
        public string $severity,
        public ?string $payload,
        public string $createdAt
    ) {
    }
}
