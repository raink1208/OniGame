<?php


namespace rain1208\oniGame\game;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Armor;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use rain1208\oniGame\GamePlayer;
use rain1208\oniGame\map\Map;
use rain1208\oniGame\OniGame;

class Game
{
    /** @var Task */
    private $gameTask;

    /** @var GamePlayer[] */
    private $players;
    /** @var GamePlayer[] Name => GamePlayer*/
    private $spectates;

    private $status;

    /** @var Map */
    private $map;

    public function __construct()
    {
        $this->status = false;
    }

    public function setMap(Map $map): void
    {
        $this->map = $map;
    }

    public function setStatus(bool $bool): void
    {
        $this->status = $bool;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function playerExists(Player $player): bool
    {
        return in_array($player->getName(),$this->players);
    }

    public function startGame(): void
    {
        $this->setStatus(true);
        OniGame::getInstance()->getScheduler()->scheduleRepeatingTask($this->gameTask = new GameTask($this), 20);
        OniGame::getInstance()->getServer()->broadcastMessage("ゲームを開始します");
        foreach ($this->players as $player) {
            $this->initPlayer($player->getPlayer());
        }
    }

    public function initPlayer(Player $player): void
    {
        if ($player->isOnline()) {
            $player->setGamemode(Player::SURVIVAL);
            $player->getArmorInventory()->clearAll();
            $player->getInventory()->clearAll();
            $player->setHealth($player->getMaxHealth());
            $player->setFood($player->getMaxFood());
            $player->removeAllEffects();
            if ($this->players[$player->getName()]->isOni()) {
                $player->getInventory()->setItem(1,Armor::get(Armor::MOB_HEAD,0,1));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS),20,5));
            } else {
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS),5,5));
            }
        }
    }

    public function spectate(Player $player): void
    {
        $this->players[$player->getName()]->setSpectating();
        $this->spectates[$player->getName()] = $this->players[$player->getName()];
        $player->setGamemode(Player::SPECTATOR);
        $player->sendMessage(OniGame::PLGUIN_TAG."あなたは観戦中です");
    }

    public function joinGame(Player $player): void
    {
        $this->players[$player->getName()] = new GamePlayer($player);
        if ($this->status) {
            $this->spectate($player);
        }
        Server::getInstance()->broadcastMessage(OniGame::PLGUIN_TAG.$player->getName()."さんが参加しました");
    }

    public function changeOni(Player $damager,Player $hitter)
    {
        $oni = $this->players[$damager->getName()];
        $escape = $this->players[$hitter->getName()];
        if ($oni->isOni() && $escape->isEscape()) {
            $oni->setEscape();
            $this->initPlayer($damager);
            $escape->setOni();
            $this->initPlayer($hitter);
            Server::getInstance()->broadcastMessage(
                OniGame::PLGUIN_TAG."鬼が".$escape->getName()."になりました"
            );
        }
    }

    public function randomOni(): void
    {
        $player = $this->players[array_rand($this->players)];
        $player->setOni();
        OniGame::getInstance()->getServer()->broadcastMessage($player->getName()."さんが鬼に選ばれました");
    }

    public function leaveGame(Player $player): void
    {
        unset($this->players[$player->getName()]);
    }

    public function endGame(): void
    {
        $this->setStatus(false);
        OniGame::getInstance()->getServer()->broadcastMessage(OniGame::PLGUIN_TAG."ゲームを終了します");
        OniGame::getInstance()->getScheduler()->cancelTask($this->gameTask->getTaskId());
    }
}