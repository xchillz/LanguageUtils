<?php

declare(strict_types=1);

namespace langutils\xchillz\command;

use customplayer\xchillz\player\CustomPlayer;
use languages\xchillz\LanguageAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

final class MyLanguageCommand extends Command
{

    public function __construct()
    {
        parent::__construct("mylanguage", "Checks your language.", "/mylanguage", [ 'mylang' ]);
    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        $language = LanguageAPI::getInstance()->getLanguageManager()->getDefaultLanguage();

        if ($sender instanceof CustomPlayer) {
            $language = $sender->getLanguage();
        }

        $sender->sendMessage($language->getMessage('MY_LANGUAGE_RESPONSE', [
            '<current_language_name>' => $language->getName($language),
            '<current_language_id>' => $language->getId()
        ]));
    }

}