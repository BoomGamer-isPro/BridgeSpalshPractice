<?php

namespace Boomgamer\MinigamesPlugin;

use Boomgamer\MinigamesPlugin\listener\PlayerListener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\world\Position;

class Main extends PluginBase {

    public Config $spawn;
    
    public function onEnable(): void {
        $this->getLogger()->info("Plugin Enabled!");
        @mkdir($this->getDataFolder());
        $this->saveResource("spawn.yml");
        $this->spawn = new Config($this->getDataFolder() . "spawn.yml", Config::YAML);
        
        $this->getServer()->getPluginManager()->registerEvents(
            new PlayerListener($this),
            $this
        );
    }

    public function onDisable(): void {
        $this->getLogger()->info("Plugin Disabled!");
    }
    
    public function getSpawnData(): Config {
        return $this->spawn;
    }
}
