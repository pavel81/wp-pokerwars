<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Contracts;

use Panda\PokerWars\DTO\BotDto;

interface BotRepositoryInterface extends RepositoryInterface
{
    public function findById(int $id): ?BotDto;

    /**
     * @return array<BotDto>
     */
    public function findAll(): array;

    public function create(BotDto $bot): int;

    public function update(BotDto $bot): bool;

    public function delete(int $id): bool;
}
