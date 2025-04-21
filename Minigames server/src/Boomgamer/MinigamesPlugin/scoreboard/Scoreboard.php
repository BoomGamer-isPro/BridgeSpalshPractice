<?php

namespace Boomgamer\MinigamesPlugin\scoreboard;


use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class Scoreboard {

    private const OBJECTIVE_NAME = "bridgesplash";

    public static function sendLobbyScoreboard(Player $player): void {
        $objective = new SetDisplayObjectivePacket();
        $objective->displaySlot = "sidebar";
        $objective->objectiveName = self::OBJECTIVE_NAME;
        $objective->displayName = TextFormat::RED . "Bridge" . TextFormat::BLUE . "Splash";
        $objective->criteriaName = "dummy";
        $objective->sortOrder = 0;
        $player->getNetworkSession()->sendDataPacket($objective);

        $lines = [
            "§r§7" . date("d/m/Y"),
            "§r§7──────────────",
            "§r§fName: §a" . $player->getName(),
            "§r§fRank: §7[§aDefault§7]",
            "§r§fCoins: §6" . mt_rand(100, 500),
            "§r§fOnline: §a" . count($player->getServer()->getOnlinePlayers()),
            "§r§7──────────────",
            "§eplay.bridgesplash.net"
        ];

       $lines = array_reverse($lines);
        $score = count($lines);
        
        foreach ($lines as $line) {
            $entry = new ScorePacketEntry();
            $entry->objectiveName = self::OBJECTIVE_NAME;
            $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
            $entry->customName = $line;
            $entry->score = $score;
            $entry->scoreboardId = $score;
            $score--;
            
            $entries[] = $entry;
        }
        $packet = new SetScorePacket();
        $packet->type = SetScorePacket::TYPE_CHANGE;
        $packet->entries = $entries;
        $player->getNetworkSession()->sendDataPacket($packet);
    }

    public static function removeScoreboard(Player $player): void {
        $packet = new RemoveObjectivePacket();
        $packet->objectiveName = self::OBJECTIVE_NAME;
        $player->getNetworkSession()->sendDataPacket($packet);
    }
}
