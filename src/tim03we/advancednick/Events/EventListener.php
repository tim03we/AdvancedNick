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

namespace tim03we\advancednick\Events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\Config;
use tim03we\advancednick\Main;

class EventListener implements Listener {

    public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}

    public function onJoin(PlayerJoinEvent $event) {
        $pfile = new Config($this->plugin->getDataFolder() . "player.yml", Config::YAML);
        $settings = new Config($this->plugin->getDataFolder() . "settings.yml", Config::YAML);
        $api = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
        $player = $event->getPlayer();
        $name = $player->getName();
        $oldGroup = $api->getUserDataMgr()->getGroup($player)->getName();
        $groupUpdate = $api->getDefaultGroup()->getName();
        if(empty($pfile->getNested($name))) {
            $pfile->setNested($name . ".number", 0);
            $pfile->setNested($name . ".isNicked", false);
            $pfile->setNested($name . ".newNick", 0);
            $pfile->setNested($name . ".oldGroup", $oldGroup);
            $pfile->setNested($name . ".oldName", $name);
        }
        $pfile->save();
    }

    public function onQuit(PlayerQuitEvent $event) {
        $pfile = new Config($this->plugin->getDataFolder() . "player.yml", Config::YAML);
        $player = $event->getPlayer();
        $name = $player->getName();
        $pfile->setNested($name . ".isNicked", false);
        $pfile->setNested($name . ".number", 0);
        $api = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
        $getOldGroup = $api->getGroup($pfile->getNested($name . ".oldGroup"));
        $api->getUserDataMgr()->setGroup($player, $getOldGroup, null);
    }
}