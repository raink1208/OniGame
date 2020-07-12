<?php


namespace rain1208\oniGame\command;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;
use rain1208\oniGame\OniGame;

class RandOni extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("randoni", $owner);
        $this->setDescription("鬼をランダムに選択します");
        $this->setPermission("op");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (OniGame::getInstance()->issetGame()) {
            OniGame::getInstance()->getGame()->randomOni();
        }
    }
}