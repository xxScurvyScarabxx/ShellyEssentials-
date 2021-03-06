<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class NickCommand extends BaseCommand{

	public function __construct(Main $main){
		parent::__construct($main, "nick", "Nick yourself", "/nick <nick> <player>", ["nick"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("nick.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(empty($args[0])){
			$sender->sendMessage(Main::PREFIX . TextFormat::GRAY . "Usage: /nick <nickname> <player>>");
			return false;
		}
		if(empty($args[1])){
			$sender->setDisplayName($args[0]);
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have been nicked $args[0]");
			return false;
		}
		if(Main::getMainInstance()->getServer()->getPlayer($args[1])){
			$player = Main::getMainInstance()->getServer()->getPlayer($args[1]);
			$player->setDisplayName($args[0]);
			$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have been nicked $args[0]");
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have nicked " . $player->getName());
		}
		return true;
	}
}