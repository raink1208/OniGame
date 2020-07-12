<?php


namespace rain1208\oniGame\command;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use rain1208\oniGame\OniGame;

class JoinGame extends PluginCommand
{
    public function __construct( Plugin $owner)
    {
        parent::__construct("joinoni", $owner);
        $this->setDescription("ゲームに参加します");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) return;
        if (OniGame::getInstance()->issetGame()) {
            OniGame::getInstance()->getGame()->joinGame($sender);
        }
    }
}