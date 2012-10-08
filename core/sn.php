<? class sn {

public static $conf;

function sn() {
	foreach (array("configure","plugins") as $key) {
		self::$key();
	}
}

function configure() { $f_user=""; $json_user="";
	chdir(system."/conf");
	$dir=opendir(".");
	while ($d=readdir($dir)) { unset($f_user); unset($json_user);
        if (is_file($d)) { if (preg_match("/[0-9a-z]+\.json/i",$d)) {
			$nm=str_replace('.json','',$d);
			$f=file_get_contents($d);
			$json=json_decode($f);
			if (file_exists("../../".project."/conf/".$d)) {
				$f_user=file_get_contents("../../".project."/conf/".$d);
				$json_user=json_decode($f_user);
			}
			if (isset($json_user)) {
				$json=array_merge_recursive($json,$json_user);
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

function cl($m) {
	$this->$m=new $m();	
}

} ?>
