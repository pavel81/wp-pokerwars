<?php

declare(strict_types=1);

namespace Panda\PokerWars\DTO;

final readonly class UserDto
{
    public function __construct(
        public int $id,
        public int $externalUserId,
        public string $provider,
        public string $nickname,
        public ?string $avatar,
        public string $status
    ) {
    }
}
