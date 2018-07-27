<?php
declare(strict_types=1);

namespace LightningStrike;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;

class LightningStrike extends PluginBase implements Listener{
    /** @var Config */
    private $lightning;
    public function onLoad(){
      $this->getLogger()->info(TextFormat::AQUA."Preparing For StartUp... STAND BY");
    }
    public function onEnable(){
      $this->saveDefaultConfig();
      $this->lightning = $this->getConfig()->getAll();
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      $this->getLogger()->info(TextFormat::GREEN."Lightning Strike RUNNING Made By MichaelM04");
    }
    /**
     * @param Player               $player
     * @param $height
     */
public function addStrike(Player $p, $height){
    $level = $p->getLevel();
    $light = new AddEntityPacket();
    $light->type = 93;
    $light->entityRuntimeId = Entity::$entityCount++;
    $light->metadata = array();
    $light->position = $p->asVector3()->add(0,$height,0);
    $light->yaw = $p->getYaw();
    $light->pitch = $p->getPitch();
    $p->getServer()->broadcastPacket($level->getPlayers(),$light);
}
public function onDeath(PlayerDeathEvent $e){
    $p = $e->getEntity();
    if($p instanceof Player){
        $this->addStrike($p,$this->lightning["death"]["height"]);
    }
  }
}