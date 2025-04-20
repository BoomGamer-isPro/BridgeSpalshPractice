<?php

namespace Boomgamer\MinigamesPlugin;

use Boomgamer\MinigamesPlugin\listener\PlayerListener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public function onEnable(): void {
        $this->getLogger()->info("Plugin Enabled!");
        $this->getServer()->getPluginManager()->registerEvents(new PlayerListener(), $this);
    }

    public function onDisable(): void {
        $this->getLogger()->info("Plugin Disabled!");
    }
}