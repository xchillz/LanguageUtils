<?php

declare(strict_types=1);

namespace langutils\xchillz\repository\impl;

use langutils\xchillz\repository\LanguageRepository;
use langutils\xchillz\utils\Paths;
use SQLite3;

final class SQLiteLanguageRepository implements LanguageRepository
{

    /** @var SQLite3 */
    private $db;

    public function __construct()
    {
        $this->db = new SQLite3(Paths::getPluginPath() . 'database.db');
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists()
    {
        $this->db->exec("CREATE TABLE IF NOT EXISTS player_languages (
            user_id TEXT PRIMARY KEY,
            language_id TEXT NOT NULL
        )");
    }

    public function save(string $userId, string $languageId)
    {
        $statement = $this->db->prepare("INSERT OR IGNORE INTO player_languages (user_id, language_id) VALUES (:user_id, :language_id)");
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':language_id', $languageId);
        $statement->execute();

        $statement->close();
    }

    public function find(string $userId)
    {
        $statement = $this->db->prepare("SELECT language_id FROM player_languages WHERE user_id = :user_id");
        $statement->bindValue(':user_id', $userId);
        $result = $statement->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);

        $statement->close();

        return $row ? $row['language_id'] : null;
    }

    public function update(string $userId, string $languageId)
    {
        $statement = $this->db->prepare("UPDATE player_languages SET language_id = :language_id WHERE user_id = :user_id");
        $statement->bindValue(':language_id', $languageId);
        $statement->bindValue(':user_id', $userId);
        $statement->execute();

        $statement->close();
    }

    public function close()
    {
        $this->db->close();
    }

}
