<?php


namespace rain1208\oniGame;


use pocketmine\plugin\PluginBase;
use rain1208\oniGame\game\Game;

class OniGame extends PluginBase
{
    public const PLGUIN_TAG = "[OniGame]";

    /** @var OniGame */
    private static $instance;

    /** @var Game */
    private $game;

    public function onEnable()
    {
        self::$instance = $this;
    }

    public static function getInstance():OniGame
    {
        return self::$instance;
    }

    public function createGame()
    {
        $this->game = new Game();
        $this->getServer()->broadcastMessage(self::PLGUIN_TAG."ゲームを生成しました");
    }

    public function getGame(): Game
    {
        return $this->game ?? null;
    }

}