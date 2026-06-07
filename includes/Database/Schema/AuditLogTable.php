<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Schema;

use Panda\PokerWars\Database\Contracts\SchemaInterface;

final class AuditLogTable implements SchemaInterface
{
    public function getSql(): string
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'pw_audit_log';
        $charsetCollate = $wpdb->get_charset_collate();

        return "
        CREATE TABLE {$tableName} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id BIGINT UNSIGNED NULL,
            event_type VARCHAR(100) NOT NULL,
            severity VARCHAR(20) NOT NULL,
            payload LONGTEXT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

            PRIMARY KEY (id),

            KEY user_id (user_id),
            KEY event_type (event_type),
            KEY severity (severity),
            KEY created_at (created_at)
        ) {$charsetCollate};
        ";
    }
}
