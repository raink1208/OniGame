<?php

namespace rain1208\oniGame;

use pocketmine\Player;

class GamePlayer
{
    /** @var Player */
    private $player;

    private $state; //Playing Spectating
    private $job; //Oni escape waiting

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