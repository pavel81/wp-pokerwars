<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Schema;

use Panda\PokerWars\Database\Contracts\SchemaInterface;

final class RewardsTable implements SchemaInterface
{
    public function getSql(): string
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'pw_rewards';
        $charsetCollate = $wpdb->get_charset_collate();

        return "
        CREATE TABLE {$tableName} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            description TEXT NULL,
            partner VARCHAR(255) NULL,
            reward_type VARCHAR(50) NOT NULL,
            reward_value VARCHAR(255) NULL,
            points_required INT UNSIGNED NOT NULL DEFAULT 0,
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NULL DEFAULT NULL,

            PRIMARY KEY (id),

            KEY reward_type (reward_type),
            KEY points_required (points_required),
            KEY is_active (is_active)
        ) {$charsetCollate};
        ";
    }
}
