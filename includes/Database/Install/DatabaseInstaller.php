<?php

declare(strict_types=1);

namespace Panda\PokerWars\Database\Install;

use Panda\PokerWars\Database\Schema\AuditLogTable;
use Panda\PokerWars\Database\Schema\BotsTable;
use Panda\PokerWars\Database\Schema\PermissionsTable;
use Panda\PokerWars\Database\Schema\RolesTable;
use Panda\PokerWars\Database\Schema\TournamentPlayersTable;
use Panda\PokerWars\Database\Schema\TournamentsTable;
use Panda\PokerWars\Database\Schema\UserRolesTable;
use Panda\PokerWars\Database\Schema\UsersTable;

final class DatabaseInstaller
{
    public function install(): void
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $schemas = [
            new UsersTable(),
            new RolesTable(),
            new PermissionsTable(),
            new UserRolesTable(),
            new TournamentsTable(),
            new TournamentPlayersTable(),
            new BotsTable(),
            new AuditLogTable(),
        ];

        foreach ($schemas as $schema) {
            dbDelta($schema->getSql());
        }
    }
}
