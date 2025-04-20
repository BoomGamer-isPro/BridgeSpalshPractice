<?php

namespace Boomgamer\MinigamesPlugin\forms;


use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class RanksForm implements Form {

    public function jsonSerialize(): array {
       return [
           "type" => "form",
             "title" => "Ranks",
             "content" => "Buy Now!",
             "buttons" => [
            ["text" => "Allay"],
            ["text" => "Golem"],
            ["text" => "Wither"],
            ["text" => "Dragon"],
                 ["text" => "Warden"]
        ]
         ];
    }

    public function handleResponse(Player $player, $data): void {
        if (is_null($data)) {
            $player->sendMessage("Menu Closed!");
            return;
        }
        if ($data == 0) {
            $player->sendMessage(TextFormat::GREEN . "Buy " . TextFormat::AQUA . "Allay" . TextFormat::GREEN . "at: <br> store.bridgesplash.com");
        }
        if ($data == 1) {
            $player->sendMessage(TextFormat::GREEN . "Buy " . TextFormat::GOLD . "Golem" . TextFormat::GREEN . "at: <br> store.bridgesplash.com");
        }
        if ($data == 2) {
            $player->sendMessage(TextFormat::GREEN . "Buy " . TextFormat::BLACK . "Wither" . TextFormat::GREEN . "at: <br> store.bridgesplash.com");
        }
        if ($data == 3) {
            $player->sendMessage(TextFormat::GREEN . "Buy " . TextFormat::DARK_PURPLE . "Dragon" . TextFormat::GREEN . "at: <br> store.bridgesplash.com");
        }
        if ($data == 4) {
            $player->sendMessage(TextFormat::GREEN . "Buy " . TextFormat::DARK_AQUA . "Warden" . TextFormat::GREEN . "at: <br> store.bridgesplash.com");
        }
    }
}