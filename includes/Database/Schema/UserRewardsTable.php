<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Schema;

use Panda\PokerWars\Database\Contracts\SchemaInterface;

final class UserRewardsTable implements SchemaInterface
{
    public function getSql(): string
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'pw_user_rewards';
        $charsetCollate = $wpdb->get_charset_collate();

        return "
        CREATE TABLE {$tableName} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id BIGINT UNSIGNED NOT NULL,
            reward_id BIGINT UNSIGNED NOT NULL,
            status VARCHAR(20) NOT NULL DEFAULT 'earned',
            earned_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            claimed_at DATETIME NULL DEFAULT NULL,
            expires_at DATETIME NULL DEFAULT NULL,

            PRIMARY KEY (id),

            KEY user_id (user_id),
            KEY reward_id (reward_id),
            KEY status (status),
            KEY earned_at (earned_at),
            KEY expires_at (expires_at)
        ) {$charsetCollate};
        ";
    }
}
