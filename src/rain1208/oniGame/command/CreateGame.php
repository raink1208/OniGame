<?php


namespace rain1208\oniGame\command;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;
use rain1208\oniGame\OniGame;

class CreateGame extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("createoni", $owner);
        $this->setDescription("鬼ごっこのゲームを作成します");
        $this->setPermission("op");
        $this->setAliases(["coni"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (OniGame::getInstance()->issetGame()) return;
        OniGame::getInstance()->createGame();
    }
}