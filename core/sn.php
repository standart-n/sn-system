<? class sn {

public static $conf;

function sn() {
	foreach (array("settings","configure","plugins") as $key) {
		self::$key();
	}
}

function settings() {
	require_once(system."/core/def.php");		
}

function configure() { $f_user=""; $json_user="";
	self::$conf=new def;
	chdir(system."/conf");
	$dir=opendir(".");
	while ($d=readdir($dir)) { unset($f_user); unset($json_user);
		if (is_file($d)) { if (preg_match("/[0-9a-z]+\.json/i",$d)) {
			$nm=str_replace('.json','',$d);
			if (file_exists("../../".project."/conf/".$d)) {
				$f=file_get_contents("../../".project."/conf/".$d);
				$json=json_decode($f);
			} else {
				$f=file_get_contents($d);
				$json=json_decode($f);
			}
			self::$conf->$nm=$json;
		} }
	}
	closedir($dir); chdir("../..");
}

function plugins() {
	if (isset(self::$conf->plugins)) {
		$data=sn::$conf->plugins;
		foreach ($data as $m) {
			if (file_exists(system."/plugins/".$m.".php")) {
				require_once(system."/plugins/".$m.".php");
				$this->$m=new $m();
			}
		}
	}
}

function cl($cl,$name=null) {
	if ($name) {
		$this->$name=new $cl();	
	} else {
		$this->$cl=new $cl();	
	}
}

} ?>
