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

    private $status;

    /** @var Map */
    private $map;

    public function __construct()
    {
        $this->status = false;
    }

    public function setMap(Map $map): void
    {
        $this->map = $map;
    }

    public function setStatus(bool $bool): void
    {
        $this->status = $bool;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function startGame(): void
    {
        $this->setStatus(true);
        OniGame::getInstance()->getScheduler()->scheduleRepeatingTask($this->gameTask = new GameTask($this), 20);
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

    public function leaveGame(Player $player): void
    {
        unset($this->players[$player->getName()]);
    }

    public function endGame(): void
    {
        $this->setStatus(false);
        OniGame::getInstance()->getServer()->broadcastMessage("ゲームを終了します");
        OniGame::getInstance()->getScheduler()->cancelTask($this->gameTask->getTaskId());
    }
}