<?php

declare(strict_types=1);

namespace Panda\PokerWars\Services;

use Panda\PokerWars\Audit\AuditEvents;
use Panda\PokerWars\Database\Contracts\UserRewardRepositoryInterface;
use Panda\PokerWars\DTO\UserRewardDto;

final class UserRewardService
{
    public function __construct(
        private readonly UserRewardRepositoryInterface $userRewards,
        private readonly AuditService $audit
    ) {
    }

    public function awardReward(
        UserRewardDto $reward
    ): int {
        $rewardId = $this->userRewards->create(
            $reward
        );

        $this->audit->log(
            AuditEvents::USER_REWARD_AWARDED,
            'info',
            $reward->userId
        );

        return $rewardId;
    }

    public function claimReward(
        UserRewardDto $reward
    ): bool {
        $updatedReward = new UserRewardDto(
            id: $reward->id,
            userId: $reward->userId,
            rewardId: $reward->rewardId,
            status: 'claimed',
            earnedAt: $reward->earnedAt,
            claimedAt: gmdate('Y-m-d H:i:s'),
            expiresAt: $reward->expiresAt
        );

        $result = $this->userRewards->update(
            $updatedReward
        );

        if ($result) {
            $this->audit->log(
                AuditEvents::USER_REWARD_CLAIMED,
                'info',
                $reward->userId
            );
        }

        return $result;
    }

    public function revokeReward(
        UserRewardDto $reward
    ): bool {
        $updatedReward = new UserRewardDto(
            id: $reward->id,
            userId: $reward->userId,
            rewardId: $reward->rewardId,
            status: 'revoked',
            earnedAt: $reward->earnedAt,
            claimedAt: $reward->claimedAt,
            expiresAt: $reward->expiresAt
        );

        $result = $this->userRewards->update(
            $updatedReward
        );

        if ($result) {
            $this->audit->log(
                AuditEvents::USER_REWARD_REVOKED,
                'warning',
                $reward->userId
            );
        }

        return $result;
    }

    /**
     * @return array<UserRewardDto>
     */
    public function findUserRewards(
        int $userId
    ): array {
        return $this->userRewards->findByUserId(
            $userId
        );
    }

    /**
     * @return array<UserRewardDto>
     */
    public function findRewardRecipients(
        int $rewardId
    ): array {
        return $this->userRewards->findByRewardId(
            $rewardId
        );
    }

    public function findReward(
        int $id
    ): ?UserRewardDto {
        return $this->userRewards->findById(
            $id
        );
    }
}
