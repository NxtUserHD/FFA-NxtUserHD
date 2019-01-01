<?php

declare(strict_types = 1);

namespace NxtUserHD\ScoreHud;

use NxtUserHD\ScoreHud\ScoreFactory;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener{
	
	/** @var Main */
	private $plugin;
	
	/**
	 * EventListener constructor.
	 *
	 * @param Main $plugin
	 */
	public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}
	
	/**
	 * @param PlayerQuitEvent $event
	 */
	public function onQuit(PlayerQuitEvent $event){
		$player = $event->getPlayer();
		ScoreFactory::removeScore($player);
	}
}