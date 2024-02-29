<?php

declare(strict_types=1);

namespace langutils\xchillz\command;

use customplayer\xchillz\player\CustomPlayer;
use languages\xchillz\langs\Language;
use languages\xchillz\LanguageAPI;
use langutils\xchillz\service\LanguageService;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

final class SetLanguageCommand extends Command
{

    /** @var LanguageService */
    private $languageService;

    public function __construct(LanguageService $languageService)
    {
        parent::__construct("setlanguage", "Modify your language.", "/setlanguage <language_id>", [ "setlang" ]);

        $this->languageService = $languageService;
    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if (!$sender instanceof CustomPlayer) {
            $sender->sendMessage(TextFormat::RED . 'Run this command in-game.');
            return;
        }

        $language = $sender->getLanguage();

        if (!isset($args[0])) {
            $sender->sendMessage($language->getMessage('SET_LANGUAGE_COMMAND', [
                '<command>' => $commandLabel
            ]));
            return;
        }

        $languageProvided = LanguageAPI::getInstance()->getLanguageManager()->getLanguageById($args[0]);

        if ($languageProvided === null) {
            $sender->sendMessage($language->getMessage('SET_LANGUAGE_LANG_NOT_FOUND', [
                '<provided_id>' => $args[0],
                '<available_langs>' => join(", ", array_map(function (Language $providedLanguage) use ($language): string {
                    return TextFormat::GRAY . $language->getName($providedLanguage) . ": " . TextFormat::WHITE . $providedLanguage->getId();
                }, LanguageAPI::getInstance()->getLanguageManager()->getLanguages()))
            ]));
            return;
        }

        if ($language->equals($languageProvided)) {
            $sender->sendMessage($language->getMessage('SET_LANGUAGE_LANG_EQUAL'));
            return;
        }

        if (!$this->languageService->updateLanguage($sender, $languageProvided)) {
            $sender->sendMessage($language->getMessage('SET_LANGUAGE_LANG_NOT_UPDATED', [
                '<new_language>' => $languageProvided->getName($language)
            ]));
            return;
        }

        $sender->setLanguage($languageProvided);
        $sender->sendMessage($language->getMessage('SET_LANGUAGE_LANG_UPDATED', [
            '<old_lang>' => $language->getName($language),
            '<new_lang>' => $language->getName($languageProvided)
        ]));
    }

}