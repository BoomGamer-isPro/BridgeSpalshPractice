<?php

namespace Boomgamer\MinigamesPlugin\forms;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class ProfileForm implements Form {

    function jsonSerialize(): array {
        return [
            "type" => "form",
            "title" => "Profile",
            "content" => "Your Profile",
            "buttons" => [
                ["text" => "Stats"],
                ["text" => "Ranks"]
            ]
        ];
    }

    function handleResponse(Player $player, $data): void
    {
        if (is_null($data)) {
            $player->sendMessage("Menu Closed!");
            return;
        }
        if ($data == 0) {
            $player->sendMessage(TextFormat::RED . "No Records!");
        }
        if ($data == 1) {
            $player->sendMessage(TextFormat::RED . "You don't have any ranks!");
        }
    }
}