<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Schema;

use Panda\PokerWars\Database\Contracts\SchemaInterface;

final class PointsLedgerTable implements SchemaInterface
{
    public function getSql(): string
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'pw_points_ledger';
        $charsetCollate = $wpdb->get_charset_collate();

        return "
        CREATE TABLE {$tableName} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id BIGINT UNSIGNED NOT NULL,
            source_type VARCHAR(50) NOT NULL,
            source_id BIGINT UNSIGNED NOT NULL,
            reference_key VARCHAR(255) NOT NULL,
            points INT NOT NULL,
            description VARCHAR(255) NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

            PRIMARY KEY (id),

            UNIQUE KEY reference_key (reference_key),

            KEY user_id (user_id),
            KEY source_type (source_type),
            KEY source_id (source_id),
            KEY created_at (created_at)
        ) {$charsetCollate};
        ";
    }
}
