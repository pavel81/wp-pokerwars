<?php

declare(strict_types=1);

namespace Panda\PokerWars\Audit;

final class AuditEvents
{
    public const TOURNAMENT_CREATED = 'TOURNAMENT_CREATED';
    public const TOURNAMENT_UPDATED = 'TOURNAMENT_UPDATED';
    public const TOURNAMENT_DELETED = 'TOURNAMENT_DELETED';

    public const PLAYER_REGISTERED = 'PLAYER_REGISTERED';
    public const PLAYER_REMOVED = 'PLAYER_REMOVED';

    public const LOGIN_SUCCESS = 'LOGIN_SUCCESS';
    public const LOGIN_FAILED = 'LOGIN_FAILED';

    public const JWT_CREATED = 'JWT_CREATED';
    public const JWT_REFRESHED = 'JWT_REFRESHED';
    
    public const BOT_CREATED = 'BOT_CREATED';

    public const BOT_UPDATED = 'BOT_UPDATED';

    public const BOT_DELETED = 'BOT_DELETED';
    
    public const GAME_CREATED = 'GAME_CREATED';
    public const GAME_UPDATED = 'GAME_UPDATED';
    public const GAME_STARTED = 'GAME_STARTED';
    public const GAME_FINISHED = 'GAME_FINISHED';
    public const GAME_DELETED = 'GAME_DELETED';
    
    public const REWARD_CREATED = 'REWARD_CREATED';

    public const REWARD_UPDATED = 'REWARD_UPDATED';

    public const REWARD_DELETED = 'REWARD_DELETED';
    
    public const USER_REWARD_AWARDED = 'USER_REWARD_AWARDED';
    public const USER_REWARD_CLAIMED = 'USER_REWARD_CLAIMED';
    public const USER_REWARD_REVOKED = 'USER_REWARD_REVOKED';
}
