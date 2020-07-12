<?php


namespace rain1208\oniGame\event;


use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use rain1208\oniGame\OniGame;

class PlayerEventListener implements Listener
{
    public function onPlayerDamageByEntity(EntityDamageByEntityEvent $event)
    {
        $damager = $event->getDamager();
        $hitter = $event->getEntity();
        if (!OniGame::getInstance()->issetGame()) return;
        if ($damager instanceof Player && $hitter instanceof Player) {
            $game = OniGame::getInstance()->getGame();
            if (!$game->playerExists($damager) && !$game->playerExists($hitter)) return;
            $game->changeOni($damager,$hitter);
        }
    }
}