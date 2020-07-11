<?php


namespace rain1208\oniGame\map;


use pocketmine\Server;
use rain1208\oniGame\ConfigManager;
use rain1208\oniGame\OniGame;

class MapManager
{
    private $maps = [];

    public function __construct()
    {
        $config = OniGame::getInstance()->getConfigManager()->getConfig(ConfigManager::MAP);
        foreach ($config->getAll() as $name => $data) {
            Server::getInstance()->loadLevel($data["Level"]);
            $world = Server::getInstance()->getLevelByName($data["Level"]);
            $this->maps[$name] = new Map($name,$world);
            var_dump($this->maps);
        }
    }
}