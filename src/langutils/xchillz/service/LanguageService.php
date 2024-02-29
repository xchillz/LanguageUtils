<?php

declare(strict_types=1);

namespace langutils\xchillz\service;

use customplayer\xchillz\player\CustomPlayer;
use languages\xchillz\langs\Language;
use languages\xchillz\LanguageAPI;
use langutils\xchillz\event\impl\PlayerLanguageSaveEvent;
use langutils\xchillz\event\impl\PlayerLanguageUpdateEvent;
use langutils\xchillz\repository\LanguageRepository;
use pocketmine\Server;

final class LanguageService
{

    /** @var LanguageRepository */
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function saveLanguage(CustomPlayer $player, Language $language)
    {
        Server::getInstance()->getPluginManager()->callEvent($ev = (new PlayerLanguageSaveEvent(
            $player,
            $language
        )));

        if ($ev->isCancelled()) return;

        $this->languageRepository->save($player->getLowerCaseName(), $language->getId());
    }

    public function findLanguage(CustomPlayer $player)
    {
        $foundLanguageId = $this->languageRepository->find($player->getLowerCaseName());

        return $foundLanguageId === null ? null : LanguageAPI::getInstance()->getLanguageManager()->getLanguageById(
            $foundLanguageId
        );
    }

    public function updateLanguage(CustomPlayer $player, Language $language): bool
    {
        Server::getInstance()->getPluginManager()->callEvent($ev = (new PlayerLanguageUpdateEvent(
            $player,
            $language
        )));

        if ($ev->isCancelled()) return false;

        $this->languageRepository->update($player->getLowerCaseName(), $language->getId());

        return true;
    }

}