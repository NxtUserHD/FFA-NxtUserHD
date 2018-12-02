<?php

namespace NxtUserHD;


use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\Vector3;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {
	
	public $prefix = "§bFFA§7 | ";
	public $pcfg;
	
	public function onEnable() {
		
		$this->getLogger()->info($this->prefix . "§aist hochgefahren!");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		@mkdir($this->getDataFolder());
        
 }
	
	public function Items(Player $player) {
		
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
		$player->getInventory()->setSize(8);
		
		$schwert = Item::get(267, 0, 1);
		$schwert->setCustomName("§7Eisenschwert");
		
		$gapple = Item::get(322, 0, 2);
		$gapple->setCustomName("§6Goldener Apfel");
		
		$bow = Item::get(261, 0, 1);
		$bow->setCustomName("§bBogen");
		
		$pfeile = Item::get(262, 0, 15);
		
		$helm = Item::get(306);
		$Chestplate = Item::get(307);
		$leggings = Item::get(308);
		$boots = Item::get(309);
		
		$player->getInventory()->setItem(0, $schwert);
		$player->getInventory()->setItem(2, $gapple);
		$player->getInventory()->setItem(4, $bow);
		$player->getInventory()->setItem(5, $pfeile);
		
		$player->getArmorInventory()->setHelmet($helm);
		$player->getArmorInventory()->setChestplate($Chestplate);
		$player->getArmorInventory()->setLeggings($leggings);
		$player->getArmorInventory()->setBoots($boots);
		
	}
	
	public function onJoin(PlayerJoinEvent $event) {
		
		$player = $event->getPlayer();
		$name = $player->getName();
		$ip = $player->getAddress();
		$UUID = $player->getUniqueId();
		$spawn = $this->getServer()->getDefaultLevel()->getSafeSpawn();
        $this->getServer()->getDefaultLevel()->loadChunk($spawn->getX(), $spawn->getZ());
        $player->teleport($spawn, 0, 0);
		$player->setGamemode(0);
        $player->setHealth(20);
        $player->setFood(20);
		
		@mkdir($this->getDataFolder() . "/spieler/");
		$pcfg = new Config($this->getDataFolder() . "/spieler/" . strtolower($name) . ".yml", Config::YAML);
		
		$event->setJoinMessage(" ");
		
		foreach($this->getServer()->getOnlinePlayers() as $onply) {
			
		 $onply->sendPopup("§f" . $name . "§6 ist bereit für den Kampf");
		 
		}
		
		if(empty($pcfg->get("Name"))) {
			
			$pcfg->set("Name : ", $name);
			$pcfg->save();
			
		}
		
		if(empty($pcfg->get("IP-Adresse"))) {
			
			$pcfg->set("IP-Adresse", $ip);
			$pcfg->save();
			
		}
		
		if(empty($pcfg->get("UniqueID"))) {
			
			$pcfg->set("UniqueID", $UUID);
			$pcfg->save();
			
		}
		
		$this->Items($player);
		
	}
	
	public function onDamage(EntityDamageEvent $event) {

        $entity = $event->getEntity();
        $level = $entity->getLevel();

        $lv = $level->getSafeSpawn();

        $r = $this->getServer()->getSpawnRadius();

        if(($entity instanceof Player) && ($entity->getPosition()->distance($level->getSafeSpawn()) <= $r)) {

            $event->setCancelled(TRUE);

        }
        else
        {

            $event->setCancelled(FALSE);

        }

    }

	public function onPlayerMove(PlayerMoveEvent $event) {

		$player = $event->getPlayer();

		
		$v = new Vector3($player->getLevel()->getSpawnLocation()->getX(),$player->getPosition()->getY(),$player->getLevel()->getSpawnLocation()->getZ());
		$r = $this->getServer()->getSpawnRadius();

		

		if(($player instanceof Player) && ($player->getPosition()->distance($v) <= $r)) {

			

			$player->sendTip("§l§aDu bist sicher!");
		}else{
			$player->sendTip("§l§4Du bist verwundbar!");			

		}
		
	}
	
	public function onRespawn(PlayerRespawnEvent $event) {
		
		$player = $event->getPlayer();
		
		$this->Items($player);
		
	}
	
	public function onDeath(PlayerDeathEvent $event) {
		
		$player = $event->getPlayer();
		
		$event->setDeathMessage(" ");
		
		if($entity instanceof Player) {
			
			$event->setDrops([]);
		
	}
	
	$ursache = $player->getLastDamageCause();
	
	if($ursache instanceof EntityDamageByEntityEvent){
		$killer = $ursache->getDamager();
			if($killer instanceof Player){
				$killer->sendPopup("+ 1");
				$event->setDeathMessage($this->prefix . "§a" . $player->getName() . " §7wurde von " . "§c" . $killer->getName() . " §7getötet!");
				
			}
		}
	}
	
	public function onBlockBreak(BlockBreakEvent $event) {
		
		$event->setCancelled(TRUE);
		
	}
	
	public function onBlockPlace(BlockPlaceEvent $event) {
		
		$event->setCancelled(TRUE);
		
	}
	
	public function onPickup(InventoryPickupItemEvent $event) {
		
		$event->setCancelled(TRUE);
		
	}
	
	public function onTransaction(InventoryTransactionEvent $event){
		
		$event->setCancelled(TRUE);
		
	}
	
}