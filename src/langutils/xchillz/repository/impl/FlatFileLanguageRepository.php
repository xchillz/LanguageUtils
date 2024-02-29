<?php

declare(strict_types=1);

namespace langutils\xchillz\repository\impl;

use langutils\xchillz\repository\LanguageRepository;
use langutils\xchillz\utils\Paths;
use pocketmine\utils\Config;

final class FlatFileLanguageRepository implements LanguageRepository
{

    /** @var Config */
    private $config;

    public function __construct()
    {
        $this->config = new Config(Paths::getPluginPath() . 'database.json');
    }

    public function save(string $userId, string $languageId)
    {
        $this->config->set($userId, $languageId);
        $this->config->save();
    }

    public function find(string $userId)
    {
        return $this->config->get($userId, null);
    }

    public function update(string $userId, string $languageId)
    {
        $this->config->set($userId, $languageId);
        $this->config->save();
    }

    public function close() {}

}