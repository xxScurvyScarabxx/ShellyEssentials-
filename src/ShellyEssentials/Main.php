<?php

declare(strict_types=1);

namespace ShellyEssentials;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use ShellyEssentials\commands\AfkCommand;
use ShellyEssentials\commands\ClearInventoryCommand;
use ShellyEssentials\commands\FeedCommand;
use ShellyEssentials\commands\FlyCommand;
use ShellyEssentials\commands\FreezeCommand;
use ShellyEssentials\commands\GamemodeAdventureCommand;
use ShellyEssentials\commands\GamemodeCreativeCommand;
use ShellyEssentials\commands\GamemodeSpectatorCommand;
use ShellyEssentials\commands\GamemodeSurvivalCommand;
use ShellyEssentials\commands\GodCommand;
use ShellyEssentials\commands\HealCommand;
use ShellyEssentials\commands\KickAllCommand;
use ShellyEssentials\commands\MuteCommand;
use ShellyEssentials\commands\NickCommand;
use ShellyEssentials\commands\PingCommand;
use ShellyEssentials\commands\SpawnCommand;
use ShellyEssentials\commands\TpAllCommand;
use ShellyEssentials\commands\VanishCommand;
use ShellyEssentials\commands\WildCommand;
use ShellyEssentials\commands\WorldTPCommand;
use ShellyEssentials\commands\XYZCommand;
use ShellyEssentials\tasks\BroadcastTask;
use ShellyEssentials\tasks\ClearLaggTask;

class Main extends PluginBase{

	public const PREFIX = TextFormat::RED . TextFormat::BOLD . "ChalxEssentials > " . TextFormat::RESET;

	/** @var Main $instance */
	protected static $instance;

	public function onEnable() : void{
		self::$instance = $this;
		$this->setMotd(str_replace("&", "§", strval($this->getConfig()->get("motd"))));
		@mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
		$this->getServer()->getCommandMap()->registerAll("ChalixEssentials", [
			new ClearInventoryCommand($this),
			new FeedCommand($this),
			new FlyCommand($this),
			new FreezeCommand($this),
			new GamemodeCreativeCommand($this),
			new GamemodeSpectatorCommand($this),
			new GamemodeSurvivalCommand($this),
			new HealCommand($this),
			new MuteCommand($this),
			new WildCommand($this),
			new NickCommand($this),
			new VanishCommand($this),
			new SpawnCommand($this),
			new XYZCommand($this),
			new GodCommand($this),
			new AfkCommand($this),
			new KickAllCommand($this),
			new TpAllCommand($this),
			new WorldTPCommand($this),
			new PingCommand($this),
			new GamemodeAdventureCommand($this)
		]);
		$this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
		$this->getScheduler()->scheduleRepeatingTask(new BroadcastTask(), intval($this->getConfig()->get("broadcast-interval")) * 20);
		$this->getScheduler()->scheduleRepeatingTask(new ClearLaggTask(), 120 * 20);
	}

	protected function setMotd(string $motd) : void{
		$this->getServer()->getNetwork()->setName(strval($motd));
	}

	public static function getMainInstance() : self{
		return self::$instance;
	}
}
