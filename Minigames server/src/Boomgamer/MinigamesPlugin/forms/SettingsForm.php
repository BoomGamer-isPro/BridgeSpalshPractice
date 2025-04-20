<?php

namespace Boomgamer\MinigamesPlugin\forms;

use pocketmine\player\Player;
use pocketmine\form\Form;
use pocketmine\utils\TextFormat;

class SettingsForm implements Form
{

    function jsonSerialize(): array
    {
        return [
            "type" => "form",
            "title" => "Settings",
            "content" => "Choose an option!",
            "buttons" => [
                ["text" => "Global Settings"],
                ["text" => "Game Settings"]
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
            $player->sendMessage(TextFormat::GREEN . "Coming Soon!");
        }
        if ($data == 1) {
            $player->sendMessage(TextFormat::GREEN . "Coming Soon!");
        }
    }
}