<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class EventPayloadDto
{
    public function __construct(
        public int $id,
        public string $eventType,
        public string $payloadJson,
        public string $createdAt
    ) {
    }
}
