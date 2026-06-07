<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database;

use Panda\PokerWars\Database\Contracts\TransactionManagerInterface;
use RuntimeException;
use Throwable;
use wpdb;

final class DatabaseTransactionManager
    implements TransactionManagerInterface
{
    private bool $transactionActive = false;

    public function __construct(
        private readonly wpdb $wpdb
    ) {
    }

    public function begin(): void
    {
        if ($this->transactionActive) {
            throw new RuntimeException(
                'Transaction already active.'
            );
        }

        $this->wpdb->query('START TRANSACTION');

        $this->transactionActive = true;
    }

    public function commit(): void
    {
        if (!$this->transactionActive) {
            throw new RuntimeException(
                'No active transaction.'
            );
        }

        $this->wpdb->query('COMMIT');

        $this->transactionActive = false;
    }

    public function rollback(): void
    {
        if (!$this->transactionActive) {
            return;
        }

        $this->wpdb->query('ROLLBACK');

        $this->transactionActive = false;
    }

    /**
     * @template T
     *
     * @param callable():T $callback
     *
     * @return T
     */
    public function transactional(
        callable $callback
    ): mixed {
        $this->begin();

        try {
            $result = $callback();

            $this->commit();

            return $result;
        } catch (Throwable $exception) {
            $this->rollback();

            throw $exception;
        }
    }
}
