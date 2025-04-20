<?php

namespace Boomgamer\MinigamesPlugin\forms;

use pocketmine\form\Form;
use pocketmine\player\Player;

class GameSelectorForm implements Form {
    function jsonSerialize(): array {
        return [
            "type" => "form",
            "title" => "Game Selector",
            "content" => "Select a game!",
            "buttons" => [
                ["text" => "Bridge"],
                ["text" => "Bedwars"]
            ]
        ];
    }

    function handleResponse(Player $player, $data): void {
        if (is_null($data)) {
            $player->sendMessage("Menu Closed!");
            return;
        }
        if ($data == 0) {
            $player->sendMessage("Sending you to Bridge!");
        }
        if ($data == 1) {
            $player->sendMessage("Sending you to Bedwars!");
        }
    }
}