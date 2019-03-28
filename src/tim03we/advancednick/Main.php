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
 * AdvancedNick is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 */

namespace tim03we\advancednick;

use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use tim03we\advancednick\Events\EventListener;
use tim03we\advancednick\commands\NickCommand;

class Main extends PluginBase implements Listener {

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->saveResource("settings.yml");
        $this->saveResource("nicks.yml");
        $this->saveResource("messages.yml");
        $this->saveResource("player.yml");
        $settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        $this->getServer()->getCommandMap()->register("nick", new NickCommand($this));
        if(!$this->getServer()->getPluginManager()->getPlugin("PurePerms")) {
            $this->getLogger()->alert("PurePerms not found!");
        }
        if(!$this->getServer()->getPluginManager()->getPlugin("PureChat")) {
            $this->getLogger()->alert("PureChat not found!");
        }
    }
}