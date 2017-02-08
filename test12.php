<?php
/* 
著作者:だいすけだいすけ
最終更新日:2017年2月9日(JPN)
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
use pocketmine\entity\Effect;
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
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityDespawnEvent;

class test12 extends PluginBase implements Listener{
/*
public $adad = 0;
public $date = [];
public $abc = 0;
public $name1 = array();//ハンター
public $name = array();//逃走者
public $xyz = false;
*/
public $gamedate = [];
public function onEnable(){
	$this->getServer()->loadLevel("world");
	$this->getServer()->getPluginManager()->registerEvents($this, $this);
	if(!file_exists($this->getDataFolder())){//configファイルを入れるフォルダがあるかを確認
		mkdir($this->getDataFolder(), 0744, true);//なければフォルダを作成
		$this->saveDefaultConfig();//resourcesにあるconfig.ymlファイルをデータフォルダに入れて保存
	}
	$this->reloadConfig();//作成されたファイルを再読み込み
	$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
	$this->gamedate["prize"]=0;//賞金
	$this->gamedate["players"]=[];
	$this->gamedate["escapee"]=[];//逃走者
	$this->gamedate["demon"]=[];//鬼 
	
	$this->gamedate["type"]="false";
	
	
	$this->gamedate["escapeecount"]=0;
	$this->gamedate["demoncount"]=0;

}

//修正しなくちゃ
public function onEntityDamageByEntity(EntityDamageEvent $event){
	$levelab = "null";
	if(Server::getInstance()->isLevelLoaded("逃走中")){//レベルオブジェクトかを条件分岐
		$levelab = Server::getInstance()->getLevelByName("逃走中");//Levelオブジェクトの取得
		
	}else 
	$this->getLogger()->info("エラーです。");
	if($event instanceof EntityDamageByEntityEvent){//EntityDamageByEntityイベントかを確認
		$player = $event->getPlayer();
		$damager = $event->getDamager(); //殴った人                
		$players = $event->getEntity();//殴られた人
		$levels = $players->getLevel();
			if($players instanceof Player and $damager instanceof Player&&$levels->getName()===$levelab->getName()){
			//error出そうな気がする…
				$vector = new Position(62,6,242, $levels);//座標を指定
				$pos = new Position(62, 6,242, $levels);//座標を指定
				//通達処理
				if($this->gamedate["players"][$player->getName()] == true){
					$players->teleport($pos);
					$players->setSpawn($vector);//スポーンをセット
					//エフェクト付与
					$players->addEffect(Effect::getEffect(10)->setDuration(5*20)->setAmplifier(10)->setVisible(false));
			$damager->sendMessage("[§4逃走中§r][個人メッセージ][逃走者]".$players->getName()."を捕まえました");
			$players->sendMessage("[§4逃走中§r][個人メッセージ][ハンター]".$damager->getName()."に捕まりました");
$this->getServer()->broadcastMessage("[§4逃走中§r][通達][ハンター]".$damager->getName()."が[逃走者]".$players->getName()."を捕まえました");
				}
			}
		}
	}//ok
	
	
	public $vector = new Position(128,5,128,$this->getServer()->getDefaultLevel());
	public $pos = new Position(128,5,128,$this->getServer()->getDefaultLevel());//軽量化の為だからね//////
	public function onJoin(PlayerJoinEvent $event){
		//new Config($this->getDataFolder() . "config.json", Config::JSON)->set($event->getPlayer()->getName(), "false");
		$player = $event->getPlayer();
		$this->gamedate["players"][$player->getName()] = "false";
		$player->teleport($this->pos);
		$player->setSpawn($this->vector);
	}



	public function onBlockTap(PlayerInteractEvent $event){
		$player = $event->getPlayer();
		$level = $player->getLevel();
		$block = $event->getBlock();
		if($block->getID()==87){
			$this->escapee($player->getName());
		}
		if($block->getID()==88){
			$this->demon($player->getName())
		}
		if($block->getID()==52){
			$this->out($player->getName());
		}
	}


	public function Quit(PlayerQuitEvent $event){
		$player = $event->getPlayer();
		$this->out($player->getName());
		}


	public function out($playername){
		if($this->gamedate["players"][$playername]==true){
			if(array_key_exists($playername,$this->gamedate["demon"])){
				unset($this->gamedate["demon"][$playername]);
				$this->gamedate = array_values($this->gamedate);//詰める(update!!)
			}else if(array_key_exists($playername,$this->gamedate["escapee"])){
				unset($this->gamedate["escapee"][$playername]);
				$this->gamedate = array_values($this->gamedate);//詰める(update!!)
			}else{
				$player->sendMessage("不明なエラーが発生。この処理は正常に終了。\n開発者より:リログすることを強くお勧めします。");
				$this->getLogger()->info("out()処理でエラー。処理は正常に終了。");
			}
		}else $player->sendMessage("参加してません。");
	}
	public function demon($playername){
		$Maxp=10;
		if($this->gamedate["demoncount"]>=$Maxp){
			if($this->gamedate["players"][$playername]==false){
				$this->gamedate["demon"][] = $playername;
				$this->gamedate["players"][$playername]=true;
				$this->gamedate["demoncount"] = $this->gamedate["demoncount"]+1;
				$player->sendMessage("ハンターに参加しました");
			}else
			$player->sendMessage("参加できないようです(既にハンター又は逃走者に参加している)");
		}else
		$player->sendMessage("ハンターに参加できないようです(参加人数が最大)[".$this->gamedate["demoncount"] ."/".$Maxp."]");
	}
	public function escapee($playername){
	//$player->sendMessage("処理中です……");
				$Maxplayers = 10;//最大人数
			//	for($i=0;count($this->gamedate["escapee"])<=$i;$i++){
//if(!$this->gamedate["escapee"][$i]==""&&count($this->gamedate["escapee"])<=$Maxplayers){//??????
	//if(!$playername==$this->gamedate["demon"]&&!$playername==$this->gamedate["escapee"]){
		if($this->gamedate["escapeecount"]>=$Maxplayers){
			if($this->gamedate["players"][$playername]==false){
				$this->gamedate["escapee"][] = $playername;
				$this->gamedate["players"][$playername]=true;
				$this->gamedate["escapeecount"] = $this->gamedate["escapeecount"]+1;
				$player->sendMessage("逃走者に参加しました");
			}else
			$player->sendMessage("参加できないようです(既にハンター又は逃走者に参加している)");
		}else
		$player->sendMessage("逃走者に参加できないようです(人数が限界)[".$this->gamedate["escapeecount"] ."/".$Maxplayers."]");
	}
class time extends PluginTask{
   public function __construct(PluginBase $owner, Player $player) {
      parent::__construct($owner);
      $this->player = $player;
   }
}


public function onRun($currentTick){
$Prize = 100;//1秒辺りの賞金、後でコンフィグからできるようにしよう。
$ops = $op;
if($xyz==false){
$xyz = true;
$pq = 60;
$Prize1=0;//賞金情報保持
} 
if(!$pq==0){
$pq--;
}
if($ops==false){
$this->getServer()->broadcastPopup("逃走中開始まであと"$pq"秒だｿ!");
}
if($ops==true){
$Prize1+$Prize=$Prize1;
$this->getServer()->broadcastPopup("逃走中終了まであと"$pq"秒だｿ!/n
賞金".$Prize1); 
}

if($pq==0&&$op==true){
$ops = false;//終わったとき
$pq = 260;
if(Server::getInstance()->isLevelLoaded("逃走中")){
    $level = Server::getInstance()->getLevelByName("逃走中");
}else{
$this->getServer()->broadcastPopup("errorです2");
}
$this->getServer()->broadcastPopup("逃走中が始まったｿﾞ! ");
$this->getServer()->broadcastMessage("逃走中が始まりました\n賞金は".$Prize."です");//賞金は26000(予定)
for($i1=0; $i1<=10; $i1++){
$namename=$name[$i1]->getName();
new Config($this->getDataFolder() . "config.json", Config::JSON)->set($namename, "false");
}
}
if($pq==0&&$op==false){
$ops =true;//始まったとき
$pq = 60;
$this->getServer()->broadcastPopup("逃走中が終わったｿﾞ! ");//ここ後で直す
$this->getServer()->broadcastMessage("逃走中が終わりました\n
賞金獲得者は". ."です");//獲得者の配列はまたあとで 
for($i2=10; $i2<=10; $i2++){
$name11=$name[$i2]->getName();
new Config($this->getDataFolder() . "config.json", Config::JSON)->set($name11, "true");
}
if(Server::getInstance()->isLevelLoaded("world")){//レベルオブジェクトかを条件分岐
    $level = Server::getInstance()->getLevelByName("world");//Levelオブジェクトの取得
}
for($i3=0;$i3<=$k; $i3++){//k=5
if(!$name1[$i3] instanceof Player){
try{
$pos = new Position(127,5,128,$Level);//まだ決まってません
$name1[$i3]->teleport($pos);
}catch(Exception $e1){
$this->getServer()->broadcastPopup("§4逃走中を実行中に正常に実行できませんでした!!");
$this->getServer()->broadcastMessage("§4逃走中を実行中に正常に実行できませんでした!!");
$this->getServer()->broadcastMessage("errorです。サーバークラッシュを回避しました");
}
}
}
