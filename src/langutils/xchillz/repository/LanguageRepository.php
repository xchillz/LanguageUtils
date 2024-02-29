<?php

declare(strict_types=1);

namespace langutils\xchillz\repository;

interface LanguageRepository
{

    public function save(string $userId, string $languageId);

    public function find(string $userId);

    public function update(string $userId, string $languageId);

    public function close();

}