<?php


namespace rain1208\oniGame\game;


use pocketmine\scheduler\Task;

class GameTask extends Task
{
    private $game;
    private $count;

    public function __construct(Game $game)
    {
        $this->game = $game;
        $this->count = 0;
    }

    public function onRun(int $currentTick)
    {

    }
}