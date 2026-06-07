<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Traits;

use wpdb;

trait TableNameTrait
{
    protected function getTableName(
        wpdb $wpdb,
        string $table
    ): string {
        return $wpdb->prefix . 'pw_' . $table;
    }
}
