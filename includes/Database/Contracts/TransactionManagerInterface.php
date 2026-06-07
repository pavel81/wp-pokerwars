<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Contracts;

interface TransactionManagerInterface
{
    public function begin(): void;

    public function commit(): void;

    public function rollback(): void;

    /**
     * @template T
     *
     * @param callable():T $callback
     *
     * @return T
     */
    public function transactional(
        callable $callback
    ): mixed;
}
