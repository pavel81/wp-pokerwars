<?php

declare(strict_types=1);

namespace Panda\PokerWars\Services;

use Panda\PokerWars\Audit\AuditEvents;
use Panda\PokerWars\Database\Contracts\RewardRepositoryInterface;
use Panda\PokerWars\DTO\RewardDto;

final class RewardService
{
    public function __construct(
        private readonly RewardRepositoryInterface $rewards,
        private readonly AuditService $audit
    ) {
    }

    public function createReward(
        RewardDto $reward
    ): int {
        $rewardId = $this->rewards->create(
            $reward
        );

        $this->audit->log(
            AuditEvents::REWARD_CREATED,
            'info'
        );

        return $rewardId;
    }

    public function updateReward(
        RewardDto $reward
    ): bool {
        $result = $this->rewards->update(
            $reward
        );

        if ($result) {
            $this->audit->log(
                AuditEvents::REWARD_UPDATED,
                'info'
            );
        }

        return $result;
    }

    public function removeReward(
        int $id
    ): bool {
        $result = $this->rewards->delete(
            $id
        );

        if ($result) {
            $this->audit->log(
                AuditEvents::REWARD_DELETED,
                'warning'
            );
        }

        return $result;
    }

    public function findReward(
        int $id
    ): ?RewardDto {
        return $this->rewards->findById(
            $id
        );
    }

    /**
     * @return array<RewardDto>
     */
    public function findAllRewards(): array
    {
        return $this->rewards->findAll();
    }

    /**
     * @return array<RewardDto>
     */
    public function findActiveRewards(): array
    {
        return $this->rewards->findActive();
    }
}
