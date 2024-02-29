<?php

declare(strict_types=1);

namespace langutils\xchillz\factory;

use langutils\xchillz\repository\impl\FlatFileLanguageRepository;
use langutils\xchillz\repository\impl\SQLiteLanguageRepository;
use langutils\xchillz\repository\LanguageRepository;
use langutils\xchillz\utils\ConfigGetter;

final class LanguageRepositoryFactory
{

    /** @var LanguageRepositoryFactory */
    private static $instance = null;
    /** @var LanguageRepository */
    private $languageRepository;

    private function __construct()
    {
        $this->languageRepository = self::create();
    }

    private static function create(): LanguageRepository
    {
        if (ConfigGetter::getDatabase() === 'sqlite') return new SQLiteLanguageRepository();

        return new FlatFileLanguageRepository();
    }

    public function getLanguageRepository(): LanguageRepository
    {
        return $this->languageRepository;
    }

    public static function getInstance(): LanguageRepositoryFactory
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}