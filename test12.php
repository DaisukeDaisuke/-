<?php
/* 
著作者:だいすけだいすけ
最終更新日:2016年3月17日(JPN)
著作協力者




2016 だいすけだいすけ(だいこん)
 */
namespace test12;

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
$adad=0;
if(!file_exists($this->getDataFolder())){//configファイルを入れるフォルダがあるかを確認
    @mkdir($this->getDataFolder(), 0744, true);//なければフォルダを作成
$this->saveDefaultConfig();//resourcesにあるconfig.ymlファイルをデータフォルダに入れて保存
}
$this->reloadConfig();//作成されたファイルを再読み込み
$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);


$name1 = array("1","2","3","4","5",);
$name = array("1","2","3","4","5","6","7","8","9","10",);


$abc=0;
}
}


public function onEntityDamageByEntity(EntityDamageEvent $event){
if(Server::getInstance()->isLevelLoaded("逃走中")){//レベルオブジェクトかを条件分岐
    $levelab = Server::getInstance()->getLevelByName("逃走中");//Levelオブジェクトの取得
}
        if($event instanceof EntityDamageByEntityEvent){//EntityDamageByEntityイベントかを確認
$player = $event->getPlayer();
                $damager = $event->getDamager(); //殴った人                
　　　　　　　　$players = $event->getEntity();//殴られた人
                               $levels = $players->getLevel();
                if($players instanceof Player and $damager instanceof Player&&$levels==$levelab){//error出そうな気がする…
$vector = new Position(62,6,242, $levels);//座標を指定
                      $pos = new Position(62, 6,242, $levels);//座標を指定
//通達処理
if(new Config($this->getDataFolder() . "config.json", Config::JSON)->get($player->getName())==true){
$players->teleport($pos);
$players->setSpawn($vector);//スポーンをセット
//エフェクト付与
$players->addEffect(Effect::getEffect(10)->setDuration(5*20)->setAmplifier(10)->setVisible(false));

$damager->sendMessage("[§4逃走中§r][個人メッセージ][逃走者]".$players->getName()."を捕まえました");
$players->sendMessage("[§4逃走中§r][個人メッセージ][ハンター]".$damager->getName()."に捕まりました");
$this->broadcast("[§4逃走中§r][通達][ハンター]".$damager->getName()."が[逃走者]".$players->getName()."を捕まえました");
}
}
}
}//ok

public function onJoin(PlayerJoinEvent $event){
//追記予定
new Config($this->getDataFolder() . "config.json", Config::JSON)->set($event->getPlayer()->getName(), "false");//値と名前を設定
}


public function onBlockTap(PlayerInteractEvent $event){
$player = $event->getPlayer();
$level = $player->getLevel();
$block = $event->getBlock();
if($block->getID()==87){
$player->sendMessage("処理中です……");


$e = 10;//最大人数
for($i=0; $i<=$e;$i++){
if(!$name[$i] instanceof Player&&$adad<$e||!$player->getName()==$name1||!$player->getName()==$name){
$name[$i] = $player->getName();
$adad++;
$player->sendMessage("逃走者に参加しました");
}else{
$player->sendMessage("参加できないようです(エラーコード1)");
}
}
$e1=10;
for($i=0; $i<=$e1;$i++){
if($block->getID()==88){
if(!$name1[$i] instanceof Player&&$abc<$k||!$player==$name1||!$player==$name){
$name1[$i] = $player;
$abc++;
$player->sendMessage("ハンターに参加しました");
}
}
}

}


public function Quit(PlayerQuitEvent $event){
$player = $event->getPlayer();
$this->getServer()->loadLevel("world");
$vector = new Position(128,5,128,$this->getServer()->getDefaultLevel());//座標を指定
$pos = new Position(128,5,128,$this->getServer()->getDefaultLevel());//座標を指定
$players->teleport($pos);
$players->setSpawn($vector);
for($i6=0; $i6<=10; $i6++){
if($name[$i6]==$player){
$name[$i6] = $i6;
$adad--;
}
}
//10まで
//5まで
for($i7=0; $i7<=5; $i7++){
if($name1[$i7]==$player){
$name1[$i7] = $i7;
$abc--;
}
}
}

class time extends PluginTask{//PluginTaskを継承したクラスです。phpファイルを分けてもできます
   public function __construct(PluginBase $owner, Player $player) {
      parent::__construct($owner);
      $this->player = $player;//Playerデータを引き継ぎます
   }
}


public function onRun($currentTick){
$ops = $op;
$xyz = false;
if($xyz==false){
$xyz = true;
$pq = 60;
} 
if(!$pq==0){
$pq--;
}
if($ops==false){
$this->getServer()->broadcastPopup("逃走中開始まであと"$pq"秒だｿ!");
}
if($ops==true){
$this->getServer()->broadcastPopup("逃走中終了まであと"$pq"秒だｿ!");
}

if($pq==0&&$op==true){
$ops = false;//終わったとき
$pq = 260;
$this->getServer()->broadcastPopup("逃走中が始まったｿﾞ! \n error コメントを表示できませんでした。\nそれらはいつか治ります");
for($i1=0; $i1<=10; $i1++){
$namename=$name[$i1]->getName();
new Config($this->getDataFolder() . "config.json", Config::JSON)->set($namename, "false");
}
}
if($pq==0&&$op==false){
$ops =true;//始まったとき
$pq = 60;
$this->getServer()->broadcastPopup("逃走中が終わったｿﾞ! \n error コメントを表示できませんでした。\nそれらはいつか治ります");
for($i2=10; $i2<=10; $i2++){
$name11=$name[$i2]->getName();
new Config($this->getDataFolder() . "config.json", Config::JSON)->set($name11, "true");
}
if(Server::getInstance()->isLevelLoaded("逃走中")){//レベルオブジェクトかを条件分岐
    $level = Server::getInstance()->getLevelByName("逃走中");//Levelオブジェクトの取得
}
for($i3=0;$i3<=$k; $i3++){//k=5
if(!$name1[$i3] instanceof Player||!$player==$name1||!$player==$name){
$pos = new Position(x座標, y座標, z座標,$Level);//まだ決まってません
$name1[$i3]->teleport($pos);


}


