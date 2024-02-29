<?php

declare(strict_types=1);

namespace langutils\xchillz\utils;

use pocketmine\Server;

final class Paths
{

    public static function getPluginPath(): string
    {
        return Server::getInstance()->getPluginPath() . 'LanguageUtils' . DIRECTORY_SEPARATOR;
    }

}