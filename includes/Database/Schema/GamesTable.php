<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Schema;

use Panda\PokerWars\Database\Contracts\SchemaInterface;

final class GamesTable implements SchemaInterface
{
    public function getSql(): string
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'pw_games';
        $charsetCollate = $wpdb->get_charset_collate();

        return "
        CREATE TABLE {$tableName} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            tournament_id BIGINT UNSIGNED NULL,
            table_name VARCHAR(100) NOT NULL,
            status VARCHAR(50) NOT NULL DEFAULT 'waiting',
            max_players INT UNSIGNED NOT NULL DEFAULT 9,
            current_players INT UNSIGNED NOT NULL DEFAULT 0,
            winner_user_id BIGINT UNSIGNED NULL,
            started_at DATETIME NULL,
            finished_at DATETIME NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NULL DEFAULT NULL,

            PRIMARY KEY (id),

            KEY tournament_id (tournament_id),
            KEY status (status),
            KEY winner_user_id (winner_user_id)
        ) {$charsetCollate};
        ";
    }
}
