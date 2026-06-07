<?php
<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Schema;

final class UsersTable
{
    public function getSql(): string
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'pw_users';
        $charsetCollate = $wpdb->get_charset_collate();

        return "
        CREATE TABLE {$tableName} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            external_user_id BIGINT UNSIGNED NOT NULL,
            provider VARCHAR(50) NOT NULL,
            nickname VARCHAR(100) NOT NULL,
            avatar VARCHAR(255) NULL,
            status VARCHAR(20) NOT NULL DEFAULT 'active',
            created_at DATETIME NOT NULL,
            updated_at DATETIME NULL,
            PRIMARY KEY (id),
            KEY external_user_id (external_user_id),
            KEY provider (provider),
            KEY status (status)
        ) {$charsetCollate};
        ";
    }
}
