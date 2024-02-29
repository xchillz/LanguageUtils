<?php

declare(strict_types=1);

namespace langutils\xchillz\listener;

use customplayer\xchillz\player\CustomPlayer;
use langutils\xchillz\service\LanguageService;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

final class PlayerJoinListener implements Listener
{

    /** @var LanguageService */
    private $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }


    /**
     * @priority LOWEST
     */
    public function onPlayerJoin(PlayerJoinEvent $event)
    {
        /** @var CustomPlayer $player */
        $player = $event->getPlayer();

        $languageFound = $this->languageService->findLanguage($player);

        if ($languageFound === null) {
            $this->languageService->saveLanguage($player, $player->getLanguage());
            return;
        }

        $player->setLanguage($languageFound);
    }

}