<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Contracts;

use Panda\PokerWars\DTO\UserDto;

interface UserRepositoryInterface
{
    public function findById(int $id): ?UserDto;

    public function findByExternalUser(
        int $externalUserId,
        string $provider
    ): ?UserDto;
}
