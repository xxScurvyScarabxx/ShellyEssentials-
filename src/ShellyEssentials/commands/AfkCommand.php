<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class AfkCommand extends BaseCommand{

	/** @var array $afk */
	public static $afk = [];

	public function __construct(Main $main){
		parent::__construct($main, "afk", "Allow yourself to be put in afk mode", "/afk", ["afk"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("afk.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(!isset(self::$afk[$sender->getName()])){
			self::$afk[$sender->getName()] = true;
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have turned on afk mode");
			Main::getMainInstance()->getServer()->broadcastMessage(TextFormat::YELLOW . $sender->getName() . " is now AFK");
		}elseif(isset(self::$afk[$sender->getName()])){
			unset(self::$afk[$sender->getName()]);
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "You have turned off afk mode");
			Main::getMainInstance()->getServer()->broadcastMessage(TextFormat::YELLOW . $sender->getName() . " is no longer AFK");
		}
		return true;
	}
}