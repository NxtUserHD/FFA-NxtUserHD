<?php

declare(strict_types = 1);

namespace NxtUserHD\ScoreHud\task;

use NxtUserHD\ScoreHud\Main;
use pocketmine\scheduler\Task;

class ScoreUpdateTask extends Task{
	
	/** @var Main */
	private $plugin;
	/** @var int */
	private $titleIndex = 0;
	
	/**
	 * ScoreUpdateTask constructor.
	 *
	 * @param Main $plugin
	 */
	public function __construct(Main $plugin){
		$this->plugin = $plugin;
		$this->titleIndex = 0;
	}
	
	/**
	 * @param int $tick
	 */
	public function onRun(int $tick){
		$this->titleIndex++;
		$players = $this->plugin->getServer()->getOnlinePlayers();
		$titles = $this->plugin->getConfig()->get("server-names");
		if(!isset($titles[$this->titleIndex])){
			$this->titleIndex = 0;
		}
		foreach($players as $player){
			$this->plugin->addScore($player, $titles[$this->titleIndex]);
		}
	}
}