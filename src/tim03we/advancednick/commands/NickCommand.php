<?php

/*
 * Copyright (c) 2019 tim03we  < https://github.com/tim03we >
 * Discord: tim03we | TP#9129
 *
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken.
 *
 * ScoreHud is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 */

declare(strict_types=1);

namespace tim03we\advancednick\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use _64FF00\PurePerms\PPGroup;
use tim03we\advancednick\Main;

class NickCommand extends Command {
	
	public function __construct(Main $plugin) {
		parent::__construct("nick", "AdvancedNick", "/nick");
		$this->setPermission("advanced.nick.use");
		$this->plugin = $plugin;
	}
	
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
		if(!$this->testPermission($sender)) {
			return false;
		}
        if(!$sender instanceof Player) {
            $sender->sendMessage("Run this Command InGame!");
            return true;
        }
        $nicks = new Config($this->plugin->getDataFolder() . "nicks.yml", Config::YAML);
        $pfile = new Config($this->plugin->getDataFolder() . "player.yml", Config::YAML);
        $settings = new Config($this->plugin->getDataFolder() . "settings.yml", Config::YAML);
        $messages = new Config($this->plugin->getDataFolder() . "messages.yml", Config::YAML);
        $pchat = new Config('../ServerFiles/format.yml', Config::YAML);

        $pAPI = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
        $replace = "§";
        $name = $sender->getName();
        $nnName = $pfile->getNested($name . ".newNick");
        $displayName = $nnName;
        $api = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
        $groupUpdate = $api->getDefaultGroup()->getName();
        $random = mt_rand(1, 20);
        $getOldGroup = $api->getGroup($pfile->getNested($name . ".oldGroup"));
        $check = explode(', ', $nicks->get($random));
        $pfileCheck = explode(', ', (string)$pfile->getNested($name . ".number"));
        $oldNametag = $pchat->getNested("groups." . $getOldGroup . ".nametag");
        if($pfile->getNested($name . ".isNicked", true)) {
            $pfile->setNested($name . ".isNicked", false);
            $pfile->getNested($name . ".oldName");
            $pfile->getNested($name . ".oldGroup");
            //$nicks->set($random, $pfile->getNested($name . ".newNick") . ", false");
            $nicks->set($pfile->getNested($name . ".number"), $pfile->getNested($name . ".newNick") . ", false");
            $nicks->save();
            $pfile->save();
            $pAPI->getUserDataMgr()->setGroup($sender, $getOldGroup, null);
            $sender->setDisplayName($pfile->getNested($name . ".oldName"));
            //$sender->setNameTag($this->convert($oldNametag, $displayName, $replace));
            $realName = $sender->getName();
            $sender->setNameTag($this->stringConvert($pchat->getNested("groups." . $getOldGroup . ".nametag"), $realName, $replace));
        } else {
            if($check[1] === "true") {
                Server::getInstance()->getLogger()->debug("No Free Nickname found for " . $sender->getName() . "!");
                $sender->sendMessage($messages->get("NoNickFound"));
                return true;
            } else {
                $pfile->setNested($name . ".isNicked", true);
                $pfile->setNested($name . ".newGroup", $groupUpdate);
                $pfile->setNested($name . ".number", strval($random));
                $pfile->save();
                $nametag = $pchat->getNested("groups." . $settings->get("DefaultGroup") . ".nametag");
                $defaultPPGroup = $pAPI->getDefaultGroup()->getName();
                $pAPI->setGroup($sender, new PPGroup($pAPI, $defaultPPGroup));
                if($nicks->get($random) === "EnteMomoFNA1, false") {
                    $nicks->set("1", "EnteMomoFNA1" . ", true");
                    $pfile->setNested($name . ".newNick", "EnteMomoFNA1");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("EnteMomoFNA1");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "MomoIsNotReal, false") {
                    $nicks->set("2", "MomoIsNotReal" . ", true");
                    $pfile->setNested($name . ".newNick", "MomoIsNotReal");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("MomoIsNotReal");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "EnderKiller, false") {
                    $nicks->set("3", "EnderKiller" . ", true");
                    $pfile->setNested($name . ".newNick", "EnderKiller");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("EnderKiller");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "Lorain9, false") {
                    $nicks->set("4", "Lorain9" . ", true");
                    $pfile->setNested($name . ".newNick", "Lorain9");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("Lorain9");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "leSurnex, false") {
                    $nicks->set("5", "leSurnex" . ", true");
                    $pfile->setNested($name . ".newNick", "leSurnex");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("leSurnex");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "kodaisyu_YT, false") {
                    $nicks->set("6", "kodaisyu_YT" . ", true");
                    $pfile->setNested($name . ".newNick", "kodaisyu_YT");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("kodaisyu_YT");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "XrayPVP, false") {
                    $nicks->set("7", "XrayPVP" . ", true");
                    $pfile->setNested($name . ".newNick", "XrayPVP");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("XrayPVP");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "ByDenis, false") {
                    $nicks->set("8", "ByDenis" . ", true");
                    $pfile->setNested($name . ".newNick", "ByDenis");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("ByDenis");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "Mqxxs, false") {
                    $nicks->set("9", "Mqxxs" . ", true");
                    $pfile->setNested($name . ".newNick", "Mqxxs");
                    $sender->setDisplayName("Mqxxs");
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "NikNakTV, false") {
                    $nicks->set("10", "NikNakTV" . ", true");
                    $pfile->setNested($name . ".newNick", "EnteMNikNakTVomoFNA1");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("EnteMNikNakTVomoFNA1");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "PsychOtterKind, false") {
                    $nicks->set("11", "PsychOtterKind" . ", true");
                    $pfile->setNested($name . ".newNick", "PsychOtterKind");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("PsychOtterKind");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "BustedCow, false") {
                    $nicks->set("12", "BustedCow" . ", true");
                    $pfile->setNested($name . ".newNick", "BustedCow");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("BustedCow");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "Porsche16, false") {
                    $nicks->set("13", "Porsche16" . ", true");
                    $pfile->setNested($name . ".newNick", "Porsche16");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("Porsche16");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "Entwischt, false") {
                    $nicks->set("14", "Entwischt" . ", true");
                    $pfile->setNested($name . ".newNick", "Entwischt");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("Entwischt");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "HitsLikeLuKeee, false") {
                    $nicks->set("15", "HitsLikeLuKeee" . ", true");
                    $pfile->setNested($name . ".newNick", "HitsLikeLuKeee");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("HitsLikeLuKeee");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "Felix950, false") {
                    $nicks->set("15", "Felix950" . ", true");
                    $pfile->setNested($name . ".newNick", "Felix950");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("Felix950");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "Siteax, false") {
                    $nicks->set("15", "Siteax" . ", true");
                    $pfile->setNested($name . ".newNick", "Siteax");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("Siteax");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "_FastMitte, false") {
                    $nicks->set("15", "_FastMitte" . ", true");
                    $pfile->setNested($name . ".newNick", "_FastMitte");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("_FastMitte");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "SamuPlayz, false") {
                    $nicks->set("15", "SamuPlayz" . ", true");
                    $pfile->setNested($name . ".newNick", "SamuPlayz");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("SamuPlayz");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                if($nicks->get($random) === "ChryZz, false") {
                    $nicks->set("15", "ChryZz" . ", true");
                    $pfile->setNested($name . ".newNick", "ChryZz");
                    $pfile->save();
                    $nnName = $pfile->getNested($name . ".newNick");
                    $displayName = $nnName;
                    $sender->setDisplayName("ChryZz");
                    $sender->setNameTag($this->convert($nametag, $displayName, $replace));
                }
                $sender->sendMessage($messages->get("NickChanged"));
                $nicks->save();
            }
        }
        return false;
    }

    public function convert(string $string, $displayName, $replace): string{
        $string = str_replace("{display_name}", $displayName, $string);
        $string = str_replace("&", $replace, $string);
        return $string;
	}

    public function stringConvert(string $string, $realName, $replace): string{
        $string = str_replace("{display_name}", $realName, $string);
        $string = str_replace("&", $replace, $string);
        return $string;
    }
}