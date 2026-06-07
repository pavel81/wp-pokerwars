<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Contracts;

use Panda\PokerWars\DTO\UserRewardDto;

interface UserRewardRepositoryInterface extends RepositoryInterface
{
    public function findById(
        int $id
    ): ?UserRewardDto;

    /**
     * @return array<UserRewardDto>
     */
    public function findByUserId(
        int $userId
    ): array;

    /**
     * @return array<UserRewardDto>
     */
    public function findByRewardId(
        int $rewardId
    ): array;

    /**
     * @return array<UserRewardDto>
     */
    public function findByStatus(
        string $status
    ): array;

    public function create(
        UserRewardDto $reward
    ): int;

    public function update(
        UserRewardDto $reward
    ): bool;

    public function delete(
        int $id
    ): bool;
}
