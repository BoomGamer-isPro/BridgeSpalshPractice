<?php

namespace Boomgamer\MinigamesPlugin\listener;


use Boomgamer\MinigamesPlugin\forms\GameSelectorForm;
use Boomgamer\MinigamesPlugin\forms\ProfileForm;
use Boomgamer\MinigamesPlugin\forms\SettingsForm;
use Boomgamer\MinigamesPlugin\forms\ShopForm;
use Boomgamer\MinigamesPlugin\scoreboard\Scoreboard;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\VanillaArmorMaterials;
use pocketmine\item\VanillaItems;
use pocketmine\player\GameMode;
use pocketmine\utils\TextFormat;
use pocketmine\world\sound\XpLevelUpSound;
use pocketmine\player\Player;
use pocketmine\world\Position;
use Boomgamer\MinigamesPlugin\Main;
use pocketmine\utils\Config;


class PlayerListener implements Listener {
    
    private Main $plugin;
    private Config $spawn;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;

        // Load spawn config from plugin data folder
        $this->spawn = new Config($this->plugin->getDataFolder() . "spawn.yml", Config::YAML);
    }

    public function onJoin(PlayerJoinEvent $joinEvent) {
        $player = $joinEvent->getPlayer();
         $data = $this->spawn->getAll();
        
       if (
            isset($data["x"], $data["y"], $data["z"], $data["world"]) &&
            is_numeric($data["x"]) &&
            is_numeric($data["y"]) &&
            is_numeric($data["z"])
        ) {
            $world = $this->plugin->getServer()->getWorldManager()->getWorldByName($data["world"]);
            if ($world !== null) {
                $position = new Position((int)$data["x"], (int)$data["y"], (int)$data["z"], $world);
                $player->teleport($position);
            } else {
                $player->sendMessage("§cLobby world not loaded or doesn't exist!");
            }
        } else {
            $player->sendMessage("§cInvalid spawn configuration.");
        }


        Scoreboard::sendLobbyScoreboard($player);

        $joinEvent->setJoinMessage(" ");
        $player->sendMessage(TextFormat::BOLD . TextFormat::RED . "Bridge" . TextFormat::BLUE . "Splash" . TextFormat::RESET . ": " . TextFormat::GREEN . "Welcome " . $player->getName());
        $player->sendTitle(TextFormat::RED . "Bridge" . TextFormat::BLUE . "Splash");
        $player->sendMessage(TextFormat::GRAY . "Make sure to join our discord: " . TextFormat::GREEN . ".gg/bridgesplash");
        $location = $player->getLocation();
        $player->getWorld()->addSound($location, new XpLevelUpSound(30));

        $player->setGamemode(GameMode::SURVIVAL);
        $player->setHealth($player->getMaxHealth());
        $player->getHungerManager()->setFood(20);

        $gameselector = VanillaItems::COMPASS();
        $profile = VanillaItems::BOOK();
        $settings = VanillaItems::AMETHYST_SHARD();
        $shop = VanillaItems::EMERALD();

        $gameselector->setCustomName("Game Selector");
        $profile->setCustomName("Profile");
        $settings->setCustomName("Settings");
        $shop->setCustomName("Shop");

        $player->getInventory()->clearAll();

        $player->getInventory()->setItem(4, $gameselector);
        $player->getInventory()->setItem(7, $shop);
        $player->getInventory()->setItem(8, $settings);
        $player->getInventory()->setItem(1, $profile);

    }

    public function onItemUse(PlayerItemUseEvent $itemUseEvent) {
        $player = $itemUseEvent->getPlayer();
        $item = $itemUseEvent->getItem();

            switch ($item->getTypeId()) {
                case ItemTypeIds::COMPASS:
                    $player->sendForm(new GameSelectorForm());
                    break;
                case ItemTypeIds::BOOK:
                    $player->sendForm(new ProfileForm());
                    break;
                case ItemTypeIds::AMETHYST_SHARD:
                    $player->sendForm(new SettingsForm());
                    break;
                case ItemTypeIds::EMERALD:
                    $player->sendForm(new ShopForm());
                    break;

            }

    }

    public function onBlockBreak(BlockBreakEvent $breakEvent) {
        $player = $breakEvent->getPlayer();
        $breakEvent->cancel();
        $player->sendMessage(TextFormat::RED . "You can't break blocks here!");
    }

    public function onBlockPlace(BlockPlaceEvent $blockPlaceEvent) {
        $player = $blockPlaceEvent->getPlayer();
        $blockPlaceEvent->cancel();
        $player->sendMessage(TextFormat::RED . "You can't place blocks here!");
    }

    public function onDamage(EntityDamageEvent $damageEvent) {
        $entity = $damageEvent->getEntity();
        $damageEvent->cancel();
    }

    public function onDrop(PlayerDropItemEvent $dropItemEvent) {
        $player = $dropItemEvent->getPlayer();
        $dropItemEvent->cancel();
    }

    public function onFallDamage(EntityDamageEvent $damageEvent) {
        $entity = $damageEvent->getEntity();
        $cause = $damageEvent->getCause();
        if($cause == $damageEvent::CAUSE_FALL) {
            $damageEvent->cancel();
        }
    }

    public function onPVP(EntityDamageByEntityEvent $event) {
        $damager = $event->getDamager();
        $entity = $event->getEntity();

        if (!$damager instanceof Player || !$entity instanceof Player) $event->cancel();
    }
}
