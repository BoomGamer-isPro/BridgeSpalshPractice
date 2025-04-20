<?php

namespace Boomgamer\MinigamesPlugin\listener;


use Boomgamer\MinigamesPlugin\forms\GameSelectorForm;
use Boomgamer\MinigamesPlugin\forms\ProfileForm;
use Boomgamer\MinigamesPlugin\forms\SettingsForm;
use Boomgamer\MinigamesPlugin\forms\ShopForm;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\VanillaArmorMaterials;
use pocketmine\item\VanillaItems;
use pocketmine\player\GameMode;
use pocketmine\utils\TextFormat;
use pocketmine\world\sound\XpLevelUpSound;

class PlayerListener implements Listener {

    public function onJoin(PlayerJoinEvent $joinEvent) {
        $player = $joinEvent->getPlayer();

        $joinEvent->setJoinMessage(" ");
        $player->sendMessage(TextFormat::BOLD . TextFormat::RED . "Bridge" . TextFormat::BLUE . "Splash" . TextFormat::RESET . ": " . TextFormat::GREEN . "Welcome " . $player->getName());
        $player->sendTitle(TextFormat::RED . "Bridge" . TextFormat::BLUE . "Splash");
        $player->sendMessage(TextFormat::GRAY . "Make sure to join our discord: " . TextFormat::GREEN . ".gg/bridgesplash");
        $location = $player->getLocation();
        $player->getWorld()->addSound($location, new XpLevelUpSound(30));

        $player->setGamemode(GameMode::ADVENTURE);
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
}