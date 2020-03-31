<?php

namespace SpawnWithItems;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\item\Item;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerRespawnEvent;

class Main extends PluginBase implements Listener {
	
	public function onLoad() : void {
		$this->getLogger()->info(TextFormat::YELLOW . "Loading SpawnWithItems v1.0.0");
	}
	
	public function onEnable() : void {
		$this->saveDefaultConfig();
		$c = $this->getConfig()->getAll();
		$num = 0;
		foreach ($c["items"] as $i) {
			$r = explode(":",$i);
			$this->itemdata[$num] = array($r[0],$r[1],$r[2]);
			$num++;
		}
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getLogger()->info(TextFormat::YELLOW . "Enabling SpawnWithItems...");
	}
	
	/**
	 * @param PlayerRespawnEvent $event
	 *
	 * @priority HIGHEST
	 * @ignoreCancelled true
	 */
	public function playerSpawn(PlayerRespawnEvent $event) : void {
		if($event->getPlayer()->hasPermission("spawnwithitems") || $event->getPlayer()->hasPermission("spawnwithitems.receive")) {
			foreach($this->itemdata as $i) {
				$item = new Item($i[0],$i[1],$i[2]);
				$event->getPlayer()->getInventory()->addItem($item);
			}
		}
	}
	
	public function onDisable() : void {
		$this->getLogger()->info(TextFormat::YELLOW . "Disabling SpawnWithItems...");
	}
}
