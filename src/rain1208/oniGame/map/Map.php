<?php


namespace rain1208\oniGame\map;


use pocketmine\level\Level;
use pocketmine\nbt\BigEndianNBTStream;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Server;

class Map
{
    private $name;
    private $original; //コピー元

    /** @var Level */
    private $world; //コピーされたもの

    public function __construct(string $name, Level $original)
    {
        $this->name = $name;
        $this->original = $original;
    }

    public function getOriginal(): Level
    {
        return $this->original;
    }

    public function getWorld(): Level
    {
        return $this->world;
    }

    public function reset(): void
    {
        Server::getInstance()->unloadLevel($this->getWorld());
        $this->copyLevel();
    }

    public function copyLevel(): void
    {
        $from = $this->getOriginal()->getName();
        $copy = $from . "copy";
        $fromPath = Server::getInstance()->getDataPath() . "worlds/" . $from;
        $copyPath = Server::getInstance()->getDataPath() . "worlds/" . $copy;
        if (!is_dir($fromPath)) return;
        $this->copy($fromPath,$copyPath);
        $nbt = new BigEndianNBTStream();
        $worldData = $nbt->readCompressed(file_get_contents($copyPath."/level.dat"));
        $data = $worldData->getCompoundTag("Data");
        $data->setString("LevelName", $copy);
        file_put_contents($copyPath . "/level.dat", $nbt->writeCompressed(new CompoundTag("",array($data))));
        Server::getInstance()->loadLevel($copy);
        $this->world = Server::getInstance()->getLevelByName($copy);
    }

    public function copy(string $from, string $copy): void
    {
        if (!is_dir($from)) return;
        $objs = scandir($from);
        mkdir($copy);
        foreach ($objs as $obj) {
            if ($obj !== "." || $obj !== "..") {
                if (is_dir($from . "/" . $obj)) {
                    $this->copy($from . "/" . $obj, $copy . "/" . $obj);
                } else {
                    copy($from . "/" . $obj, $copy . "/" . $obj);
                }
            }
        }
    }
}