<?php

namespace rain1208\oniGame;

use pocketmine\Player;

class GamePlayer
{
    /** @var Player */
    private $player;

    private $state; //Playing Spectating
    private $job; //Oni Escape waiting

    public function __construct(Player $player)
    {
        $this->player = $player;
        $this->initPlayer();
    }

    public function initPlayer()
    {
        $this->state = "Spectating";
        $this->job = "waiting";
    }

    public function getName():string
    {
        return $this->player->getName();
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function isOni(): bool
    {
        return ($this->job === "Oni")? true : false;
    }

    public function setOni(): void
    {
        $this->job = "Oni";
    }

    public function isEscape(): bool
    {
        return ($this->job === "Escape")? true : false;
    }

    public function setEscape(): void
    {
        $this->job = "Escape";
    }

    public function isPlaying(): bool
    {
        return ($this->state == "playing")? true : false;
    }

    public function setPlaying():void
    {
        $this->state = "Playing";
    }

    public function isSpectating():bool
    {
        return ($this->state == "Spectating")? true : false;
    }

    public function setSpectating()
    {
        $this->state = "Spectating";
    }
}