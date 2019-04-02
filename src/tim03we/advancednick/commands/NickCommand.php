class nickCommand extends Command {

    public function __construct($name, $description = "", $usageMessage = null, $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player){
            if ($sender->hasPermission("nick.perm")){
                if (isset(Main::$players[$sender->getName()])){
                    $rangPlayer = Main::$players[$sender->getName()];
                    $nick = Main::$nicks[array_rand(Main::$nicks)];
                    if($rangPlayer->getNick() === "n"){
                        $rangPlayer->setNick($nick);
                        $sender->sendMessage("§7Dein Nickname lautet: $nick");
                    }else{
                        $rangPlayer->setNick("n");
                        $sender->sendMessage("§7Du bist nun nicht mehr genickt.");
                    }
                }
            }
        }
    }
}
