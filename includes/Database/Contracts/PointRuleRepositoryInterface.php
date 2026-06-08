<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Contracts;

use Panda\PokerWars\DTO\PointRuleDto;

interface PointRuleRepositoryInterface extends RepositoryInterface
{
    public function findById(
        int $id
    ): ?PointRuleDto;

    public function findByEventType(
        string $eventType
    ): ?PointRuleDto;

    /**
     * @return array<PointRuleDto>
     */
    public function findAll(): array;

    /**
     * @return array<PointRuleDto>
     */
    public function findEnabled(): array;

    public function create(
        PointRuleDto $rule
    ): int;

    public function update(
        PointRuleDto $rule
    ): bool;

    public function delete(
        int $id
    ): bool;
}
