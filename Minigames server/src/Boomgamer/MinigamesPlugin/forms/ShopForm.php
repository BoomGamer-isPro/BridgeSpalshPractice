<?php

namespace Boomgamer\MinigamesPlugin\forms;


use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class ShopForm implements Form {

     public function jsonSerialize(): array
     {
         return [
             "type" => "form",
             "title" => "Shop",
             "content" => "Buy Something!",
             "buttons" => [
                 ["text" => "Ranks"],
                 ["text" => "Cosmetics"]
             ]
         ];
     }

     public function handleResponse(Player $player, $data): void {
         if (is_null($data)) {
             $player->sendMessage("Menu Closed!");
             return;
         }
         if ($data == 0) {
             $player->sendForm(new RanksForm());
         }
         if ($data == 1) {
             $player->sendMessage(TextFormat::GREEN . "Coming Soon!");
         }
     }

}