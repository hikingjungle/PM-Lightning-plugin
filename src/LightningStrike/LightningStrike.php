<?php

namespace LightningStrike;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class LightningStrike extends PluginBase implements Listener{
    /** @var Config */
    private $lightning;
	
    public function onEnable(){
      $this->saveDefaultConfig();
      
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    /**
     * @param Player               $player
     * @param $height
     */

public function addStrike(Player $p){
    $level = $p->getLevel();
    $light = new AddEntityPacket();
    $light->type = 93;
    $light->entityRuntimeId = Entity::$entityCount++;
    $light->metadata = array();
    $light->position = $p->asVector3()->add(0,$height = 0);
    $light->yaw = $p->getYaw();
    $light->pitch = $p->getPitch();
    $p->getServer()->broadcastPacket($level->getPlayers(),$light);
}
public function onQuit(PlayerQuitEvent $e){
	$p = $e->getplayer();
	if($p instanceof Player){
		
		$quit = ($this->getConfig()->get("quit"));
		
	    $this->addStrike($p, $quit);
	}
}
public function onJoin(PlayerJoinEvent $e){
	$p = $e->getplayer();
	if($p instanceof Player){
		
		$join = ($this->getConfig()->get("join"));
		
		$this->addStrike($p, $join);
  }
}
public function onDeath(PlayerDeathEvent $e){
    $p = $e->getEntity();
    if($p instanceof Player){
		
		$death = ($this->getConfig()->get("death"));
		
        $this->addStrike($p, $death);
    }
  }
}
