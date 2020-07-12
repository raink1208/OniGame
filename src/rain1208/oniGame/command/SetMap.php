<?php


namespace rain1208\oniGame\command;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;

class SetMap extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("setmap", $owner);
        $this->setDescription("マップを選択します");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

    }
}