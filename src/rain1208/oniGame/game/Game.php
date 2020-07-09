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
        OniGame::getInstance()->getServer()->broadcastMessage("ゲームを開始します");
    }

    public function spectate(Player $player): void
    {
        $this->players[$player->getName()]->setSpectating();
        $player->setGamemode(Player::SPECTATOR);
    }

    public function joinGame(Player $player): void
    {
        $this->players[$player->getName()] = new GamePlayer($player);
    }

    public function leaveGame(Player $player):void
    {
        unset($this->players[$player->getName()]);
    }

    public function endGame(): void
    {
        OniGame::getInstance()->getServer()->broadcastMessage("ゲームを終了します");
        OniGame::getInstance()->getScheduler()->cancelTask($this->gameTask->getTaskId());
    }
}