<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Repositories;

use Panda\PokerWars\Database\Traits\TableNameTrait;
use wpdb;

abstract class AbstractRepository
{
    use TableNameTrait;

    public function __construct(
        protected readonly wpdb $wpdb
    ) {
    }

    protected function table(string $table): string
    {
        return $this->getTableName(
            $this->wpdb,
            $table
        );
    }
}
