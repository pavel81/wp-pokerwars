<?php

declare(strict_types=1);

namespace Panda\PokerWars\Services;

use Panda\PokerWars\Audit\AuditEvents;
use Panda\PokerWars\Database\Contracts\PointRuleRepositoryInterface;
use Panda\PokerWars\DTO\PointRuleDto;

final class PointRuleService
{
    public function __construct(
        private readonly PointRuleRepositoryInterface $rules,
        private readonly AuditService $audit
    ) {
    }

    public function createRule(
        PointRuleDto $rule
    ): int {
        $id = $this->rules->create($rule);

        $this->audit->log(
            AuditEvents::POINT_RULE_CREATED,
            'info'
        );

        return $id;
    }

    public function updateRule(
        PointRuleDto $rule
    ): bool {
        $result = $this->rules->update($rule);

        if ($result) {
            $this->audit->log(
                AuditEvents::POINT_RULE_UPDATED,
                'info'
            );
        }

        return $result;
    }

    public function removeRule(
        int $id
    ): bool {
        $result = $this->rules->delete($id);

        if ($result) {
            $this->audit->log(
                AuditEvents::POINT_RULE_DELETED,
                'warning'
            );
        }

        return $result;
    }

    public function findRuleByEvent(
        string $eventType
    ): ?PointRuleDto {
        return $this->rules->findByEventType(
            $eventType
        );
    }

    /**
     * @return array<PointRuleDto>
     */
    public function findEnabledRules(): array
    {
        return $this->rules->findEnabled();
    }
}
