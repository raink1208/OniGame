<?php


namespace rain1208\oniGame;


use pocketmine\utils\Config;

class ConfigManager
{
    private $configs = [];
    const MAP = 0;
    const KIT = 1;

    public function __construct()
    {
        $folder = OniGame::getInstance()->getDataFolder();
        $this->configs[self::MAP] = new Config($folder . "map.json", Config::JSON);
    }

    public function getConfig(int $n): ?Config
    {
        return isset($this->configs[$n])? $this->configs[$n] : null;
    }
}