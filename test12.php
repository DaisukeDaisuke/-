<?php

namespace test12;
//Not Event

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\item\Item;
use pocketmine\tile\Sign;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Entity\entity;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\level\Explosion;
use pocketmine\entity\Zombie;
use pocketmine\entity\Villager;
use pocketmine\entity\Snowball;
use pocketmine\level\Position;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\level\format\FullChunk;
use pocketmine\level\format\mcregion\Chunk;
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\CallbackTask;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\Byte;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Double;
use pocketmine\nbt\tag\Enum;
use pocketmine\nbt\tag\Float;
use pocketmine\nbt\tag\Int;
use pocketmine\nbt\tag\String;
use pocketmine\utils\TextFormat;
use pocketmine\utils\MainLogger;
use pocketmine\entity\Effect;
use pocketmine\entity\InstantEffect;
use pocketmine\item\Item as ItemItem;
use pocketmine\math\AxisAlignedBB;

//Event

use pocketmine\event\Listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\event\server\RemoteServerCommandEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\entity\EntityDespawnEvent; 
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class test12 extends PluginBase implements Listener{

public function onEnable(){
$this->getServer() -> getPluginManager() -> registerEvents($this, $this);
if(!file_exists($this->getDataFolder())){//configファイルを入れるフォルダがあるかを確認
    @mkdir($this->getDataFolder(), 0744, true);//なければフォルダを作成
$this->saveDefaultConfig();//resourcesにあるconfig.ymlファイルをデータフォルダに入れて保存
}
$this->reloadConfig();//作成されたファイルを再読み込み
$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
}
}
