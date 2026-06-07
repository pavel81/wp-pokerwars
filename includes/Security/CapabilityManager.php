<?php

declare(strict_types=1);

namespace Panda\PokerWars\Security;

final class CapabilityManager
{
    public const MANAGE = 'pokerwars_manage';

    public const MANAGE_USERS = 'pokerwars_manage_users';

    public const MANAGE_BOTS = 'pokerwars_manage_bots';

    public const MANAGE_TOURNAMENTS = 'pokerwars_manage_tournaments';

    public const MANAGE_NOTIFICATIONS = 'pokerwars_manage_notifications';

    public const VIEW_LOGS = 'pokerwars_view_logs';

    public const MANAGE_SECURITY = 'pokerwars_manage_security';

    public const MANAGE_SETTINGS = 'pokerwars_manage_settings';

    public const VIEW_STATS = 'pokerwars_view_stats';

    /**
     * @return string[]
     */
    public function getCapabilities(): array
    {
        return [
            self::MANAGE,
            self::MANAGE_USERS,
            self::MANAGE_BOTS,
            self::MANAGE_TOURNAMENTS,
            self::MANAGE_NOTIFICATIONS,
            self::VIEW_LOGS,
            self::MANAGE_SECURITY,
            self::MANAGE_SETTINGS,
            self::VIEW_STATS,
        ];
    }

    public function registerCapabilities(): void
    {
        $role = get_role('administrator');

        if ($role === null) {
            return;
        }

        foreach ($this->getCapabilities() as $capability) {
            $role->add_cap($capability);
        }
    }

    public function removeCapabilities(): void
    {
        $role = get_role('administrator');

        if ($role === null) {
            return;
        }

        foreach ($this->getCapabilities() as $capability) {
            $role->remove_cap($capability);
        }
    }
}
