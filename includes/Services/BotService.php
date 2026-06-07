<?php

declare(strict_types=1);

namespace Panda\PokerWars\Services;

use Panda\PokerWars\Audit\AuditEvents;
use Panda\PokerWars\Database\Contracts\BotRepositoryInterface;
use Panda\PokerWars\DTO\BotDto;

final class BotService
{
    public function __construct(
        private readonly BotRepositoryInterface $bots,
        private readonly AuditService $audit
    ) {
    }

    public function createBot(
        BotDto $bot
    ): int {
        $botId = $this->bots->create(
            $bot
        );

        $this->audit->log(
            AuditEvents::BOT_CREATED,
            'info'
        );

        return $botId;
    }

    public function updateBot(
        BotDto $bot
    ): bool {
        $result = $this->bots->update(
            $bot
        );

        if ($result) {
            $this->audit->log(
                AuditEvents::BOT_UPDATED,
                'info'
            );
        }

        return $result;
    }

    public function removeBot(
        int $id
    ): bool {
        $result = $this->bots->delete(
            $id
        );

        if ($result) {
            $this->audit->log(
                AuditEvents::BOT_DELETED,
                'warning'
            );
        }

        return $result;
    }

    public function findBot(
        int $id
    ): ?BotDto {
        return $this->bots->findById(
            $id
        );
    }

    /**
     * @return array<BotDto>
     */
    public function findAllBots(): array
    {
        return $this->bots->findAll();
    }
}
