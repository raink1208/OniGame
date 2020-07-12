<?php


namespace rain1208\oniGame;


use pocketmine\plugin\PluginBase;
use rain1208\oniGame\event\PlayerEventListener;
use rain1208\oniGame\game\Game;
use rain1208\oniGame\map\MapManager;

class OniGame extends PluginBase
{
    public const PLGUIN_TAG = "[OniGame]";

    /** @var OniGame */
    private static $instance;

    private $configManager;
    private $mapManager;

    /** @var Game */
    private $game;

    public function onEnable()
    {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEventListener(), $this);

        $this->configManager = new ConfigManager();
        $this->mapManager = new MapManager();

        $this->registarCommand();
    }

    private function registarCommand(): void {
        $map = $this->getServer()->getCommandMap();
        $command = [
            "setOni" => "rain1208\onigame\command\SetOni",
            "startOni" => "rain1208\onigame\command\StartOni",
            "setMap" => "rain1208\onigame\command\SetMap",
            "joinoni" => "rain1208\onigame\command\JoinGame",
            "createoni" => "rain1208\onigame\command\CreateGame"
        ];

        foreach ($command as $item => $class) {
            $map->register("onigame", new $class($this));
        }
    }

    public static function getInstance():OniGame
    {
        return self::$instance;
    }

    public function getConfigManager(): ConfigManager
    {
        return $this->configManager;
    }

    public function createGame()
    {
        $this->game = new Game();
        $this->getServer()->broadcastMessage(self::PLGUIN_TAG."ゲームを生成しました");
    }

    public function issetGame(): bool
    {
        return (isset($game))? true : false;
    }

    public function startGame(): void
    {
        if (!isset($this->game)) return;
        $this->game->startGame();
    }

    public function getGame(): Game
    {
        return $this->game ?? null;
    }

}