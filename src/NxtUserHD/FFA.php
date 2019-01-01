<?php

namespace NxtUserHD;

use pocketmine\plugin\PluginBase;  
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\math\Vector3;

use pocketmine\item\enchantment\{
    Enchantment,
    EnchantmentInstance
};

use pocketmine\event\block\{
    SignChangeEvent,
    BlockBreakEvent,
    BlockPlaceEvent
};

use pocketmine\event\player\{
    PlayerInteractEvent,
    PlayerMoveEvent,
    PlayerDropItemEvent,
    PlayerQuitEvent,
    PlayerJoinEvent,
    PlayerExhaustEvent,
    PlayerChatEvent,
    PlayerDeathEvent,
    PlayerRespawnEvent
};

use pocketmine\event\entity\{
    EntityDamageByEntityEvent,
    EntityDamageEvent,
    EntityLevelChangeEvent
};


class FFA extends PluginBase implements Listener{

    	public function onEnable(){
    	
       		$this->getServer()->getPluginManager()->registerEvents($this, $this);
        	$this->getLogger()->info("§aFFA wurde Aktiviert!");
        	
     	}
    
    	public function onJoin(PlayerJoinEvent $e){
    	
        	$player = $e->getPlayer();
        	$name = $player->getDisplayName();
		
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
        $spawn = $this->getServer()->getDefaultLevel()->getSafeSpawn();
        $this->getServer()->getDefaultLevel()->loadChunk($spawn->getX(), $spawn->getZ());
        $player->teleport($spawn, 0, 0);
		$player->setGamemode(0);
        $player->setHealth(20);
        $player->setFood(20);
        $player->sendPopup("§bFFA§7 | §eWillkommen " . $name);
		$player->sendMessage("§bFFA§7 | §eWillkommen");
		$e->setJoinMessage(" ");
		
		foreach($this->getServer()->getOnlinePlayers() as $onply) {
			
		 $onply->sendPopup("§f" . $name . "§6 ist bereit für den Kampf");
		
          	$player->getArmorInventory()->clearAll();
          	
          	/* Helm */
		$helmet = Item::get(310, 0, 1);
		
		$protection = Enchantment::getEnchantment(0);
        	$protection = new EnchantmentInstance($protection, 2);
		$helmet->addEnchantment($protection);

		$player->getArmorInventory()->setHelmet($helmet);
		
		/* Brustplatte */
		
		$brustplatte = Item::get(311, 0, 1);
		
		$protection = Enchantment::getEnchantment(0);
        	$protection = new EnchantmentInstance($protection, 2);
		$brustplatte->addEnchantment($protection);
		
		$player->getArmorInventory()->setChestplate($brustplatte);
		
		/* Hose */
		
		$hose = Item::get(312, 0, 1);
		
		$protection = Enchantment::getEnchantment(0);
        	$protection = new EnchantmentInstance($protection, 2);
		$hose->addEnchantment($protection);
		
		$player->getArmorInventory()->setLeggings($hose);
		
		/* Schuhe */
		
		$schuhe = Item::get(313, 0, 1);
		
		$protection = Enchantment::getEnchantment(0);
        	$protection = new EnchantmentInstance($protection, 2);
		$schuhe->addEnchantment($protection);
		
		$player->getArmorInventory()->setBoots($schuhe);
		
		/* Schwert */
		
		$schwert = Item::get(276, 0, 1);
		
		$sharpness = Enchantment::getEnchantment(9);
        	$sharpness = new EnchantmentInstance($sharpness, 2);
		$schwert->addEnchantment($sharpness);
		
		$player->getInventory()->addItem($schwert);
		
          	$player->getInventory()->addItem(Item::get(322, 0, 5));
          	$player->getInventory()->addItem(Item::get(364, 0, 64));
          	
    	}
		
	}
    	
    	public function onRespawn(PlayerRespawnEvent $e){
           	$player = $e->getPlayer();
          	
          	$player->getArmorInventory()->clearAll();
          	
          	/* Helm */
		$helmet = Item::get(310, 0, 1);
		
		$protection = Enchantment::getEnchantment(0);
        	$protection = new EnchantmentInstance($protection, 2);
		$helmet->addEnchantment($protection);

		$player->getArmorInventory()->setHelmet($helmet);
		
		/* Brustplatte */
		
		$brustplatte = Item::get(311, 0, 1);
		
		$protection = Enchantment::getEnchantment(0);
        	$protection = new EnchantmentInstance($protection, 2);
		$brustplatte->addEnchantment($protection);
		
		$player->getArmorInventory()->setChestplate($brustplatte);
		
		/* Hose */
		
		$hose = Item::get(312, 0, 1);
		
		$protection = Enchantment::getEnchantment(0);
        	$protection = new EnchantmentInstance($protection, 2);
		$hose->addEnchantment($protection);
		
		$player->getArmorInventory()->setLeggings($hose);
		
		/* Schuhe */
		
		$schuhe = Item::get(313, 0, 1);
		
		$protection = Enchantment::getEnchantment(0);
        	$protection = new EnchantmentInstance($protection, 2);
		$schuhe->addEnchantment($protection);
		
		$player->getArmorInventory()->setBoots($schuhe);
		
		/* Schwert */
		
		$schwert = Item::get(276, 0, 1);
		
		$sharpness = Enchantment::getEnchantment(9);
        	$sharpness = new EnchantmentInstance($sharpness, 2);
		$schwert->addEnchantment($sharpness);
		
		$player->getInventory()->addItem($schwert);
		
          	$player->getInventory()->addItem(Item::get(322, 0, 5));
          	$player->getInventory()->addItem(Item::get(364, 0, 64));
          	
     	}
		
		public function onDamage(EntityDamageEvent $event) {

        $player = $event->getEntity();
        $level = $player->getLevel();

        $lv = $level->getSafeSpawn();

        $r = $this->getServer()->getSpawnRadius();

        if(($player instanceof Player) && ($player->getPosition()->distance($level->getSafeSpawn()) <= $r)) {

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
     	
    	public function onPlayerDeath(PlayerDeathEvent $e){
        	if($e->getEntity() instanceof Player){
            		$e->setDrops([]);
            	}
            	
		$player = $e->getPlayer();
		$causa = $player->getLastDamageCause();
		
		if($causa instanceof EntityDamageByEntityEvent){
			$killer = $causa->getDamager();
			if($killer instanceof Player){
				$killer->setHealth(20);
				$killer->sendPopup("§7--== [ §b+§c20 <3 §7] ==--");
				$e->setDeathMessage("§c".$player->getDisplayName()." §7wurde getötet von§b ".$killer->getDisplayName());
				}
			}
		}
	}