<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Contracts;

use Panda\PokerWars\DTO\RewardDto;

interface RewardRepositoryInterface extends RepositoryInterface
{
    public function findById(
        int $id
    ): ?RewardDto;

    /**
     * @return array<RewardDto>
     */
    public function findAll(): array;

    /**
     * @return array<RewardDto>
     */
    public function findActive(): array;

    public function create(
        RewardDto $reward
    ): int;

    public function update(
        RewardDto $reward
    ): bool;

    public function delete(
        int $id
    ): bool;
}
