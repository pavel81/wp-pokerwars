<?php

declare(strict_types=1);

namespace Panda\PokerWars\Integrations\Members;

final class MembersBridge
{
    public function isAvailable(): bool
    {
        return class_exists(
            '\Panda\Members\Plugin'
        );
    }
}
