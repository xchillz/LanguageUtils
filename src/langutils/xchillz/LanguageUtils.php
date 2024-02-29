<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace langutils\xchillz;

use Exception;
use languages\xchillz\LanguageAPI;
use langutils\xchillz\command\MyLanguageCommand;
use langutils\xchillz\command\SetLanguageCommand;
use langutils\xchillz\factory\LanguageRepositoryFactory;
use langutils\xchillz\listener\PlayerJoinListener;
use langutils\xchillz\service\LanguageService;
use langutils\xchillz\utils\ConfigGetter;
use pocketmine\plugin\PluginBase;

final class LanguageUtils extends PluginBase
{

    public function onEnable()
    {
        $this->saveDefaultConfig();
        $this->saveResource('messages.json');

        try {
            ConfigGetter::initialize($this->getConfig());
            LanguageAPI::getInstance()->getLanguageManager()->loadMessages(
                json_decode(file_get_contents($this->getDataFolder() . 'messages.json'), true)
            );
        } catch (Exception $exception) {
            $this->getLogger()->logException($exception);
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }

        $languageService = new LanguageService(LanguageRepositoryFactory::getInstance()->getLanguageRepository());

        $this->getServer()->getCommandMap()->registerAll('langutils', [
            new SetLanguageCommand($languageService),
            new MyLanguageCommand()
        ]);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerJoinListener($languageService), $this);
    }

    public function onDisable()
    {
        LanguageRepositoryFactory::getInstance()->getLanguageRepository()->close();
    }

}