<?php


namespace rain1208\oniGame\command;


use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;

class StartOni extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("startoni", $owner);
        $this->setDescription("ゲームを開始します");
        $this->setPermission("op");
    }
}