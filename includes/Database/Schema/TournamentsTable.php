<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Schema;

final class TournamentsTable implements SchemaInterface
{
    public function getSql(): string
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'pw_tournaments';
        $charsetCollate = $wpdb->get_charset_collate();

        return "
        CREATE TABLE {$tableName} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            status VARCHAR(50) NOT NULL DEFAULT 'draft',
            buy_in DECIMAL(12,2) NOT NULL DEFAULT 0.00,
            max_players INT UNSIGNED NOT NULL DEFAULT 0,
            starts_at DATETIME NULL,
            ends_at DATETIME NULL,
            winner_user_id BIGINT UNSIGNED NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NULL DEFAULT NULL,

            PRIMARY KEY (id),

            KEY status (status),
            KEY starts_at (starts_at),
            KEY ends_at (ends_at),
            KEY winner_user_id (winner_user_id)
        ) {$charsetCollate};
        ";
    }
}
