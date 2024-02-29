<?php

declare(strict_types=1);

namespace langutils\xchillz\event;

use customplayer\xchillz\player\CustomPlayer;
use languages\xchillz\langs\Language;
use pocketmine\event\Cancellable;
use pocketmine\event\Event;

abstract class PlayerLanguageEvent extends Event implements Cancellable
{

    /** @var CustomPlayer */
    private $player;
    /** @var Language */
    private $language;

    public function __construct(CustomPlayer $player, Language $language)
    {
        $this->player = $player;
        $this->language = $language;
    }

    public function getPlayer(): CustomPlayer
    {
        return $this->player;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

}