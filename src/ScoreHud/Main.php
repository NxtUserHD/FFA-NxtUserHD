<?php

declare(strict_types = 1);

namespace NxtUserHD\ScoreHud;

use NxtUserHD\ScoreHud\ScoreFactory;
use NxtUserHD\ScoreHud\task\ScoreUpdateTask;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{
	
	public function onEnable(): void{
		$this->saveDefaultConfig();
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->getScheduler()->scheduleRepeatingTask(new ScoreUpdateTask($this), (int) $this->getConfig()->get("update-interval") * 20);
		$this->getLogger()->info("Scoreboard v1 enabled");
	}
	
	/**
	 * @param Player $player
	 * @param string $title
	 */
	public function addScore(Player $player, string $title): void{
		ScoreFactory::setScore($player, $title);
		$this->updateScore($player);
	}
	
	/**
	 * @param Player $player
	 */
	public function updateScore(Player $player): void{
		$i = 0;
		foreach($this->getConfig()->get("score-lines") as $line){
			$i++;
			if($i <= 15){
				ScoreFactory::setScoreLine($player, $i, $this->process($player, $line));
			}
		}
	}
	
	public function process(Player $player, string $string): string{
		
		$coins = new Config("/root/Server/Coins/" . $player->getName() . ".yml", Config::YAML);
		
		$string = str_replace("{name}", $player->getName(), $string);
		$string = str_replace("{online}", count($this->getServer()->getOnlinePlayers()), $string);
		$string = str_replace("{coins}", $coins->get("coins"), $string);
		return $string;
	}
}