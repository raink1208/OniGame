<?php


namespace rain1208\oniGame\game;


use pocketmine\Player;
use pocketmine\scheduler\Task;
use rain1208\oniGame\GamePlayer;
use rain1208\oniGame\map\Map;
use rain1208\oniGame\OniGame;

class Game
{
    /** @var Task */
    private $gameTask;

    /** @var GamePlayer[] */
    private $players;
    private $spectates;

    /** @var Map */
    private $map;

    public function setMap(Map $map):void
    {
        $this->map = $map;

    }

    public function startGame():void
    {
        OniGame::getInstance()->getScheduler()->scheduleRepeatingTask($this->gameTask = new GameTask($this),20);
    }

    public function joinGame(Player $player): void
    {
        $this->players[$player->getName()] = new GamePlayer($player);
    }
}