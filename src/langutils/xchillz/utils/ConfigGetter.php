<?php

declare(strict_types=1);

namespace langutils\xchillz\utils;

use langutils\xchillz\exception\InvalidConfigurationException;
use pocketmine\utils\Config;

final class ConfigGetter
{

    /** @var string */
    private static $database;

    /**
     * @throws InvalidConfigurationException
     */
    public static function initialize(Config $config)
    {
        self::checkEntries($config->getAll());

        self::$database = $config->get('database');
    }

    /**
     * @throws InvalidConfigurationException
     */
    private static function checkEntries(array $entries)
    {
        $database = $entries['database'] ?? 'null';

        if (!in_array($database, ['sqlite', 'flatfile'])) throw new InvalidConfigurationException(
            "Database '$database' must be one of the following values: sqlite, flatfile."
        );
    }

    public static function getDatabase(): string
    {
        return self::$database;
    }

}