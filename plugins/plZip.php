<?php class plZip extends sn {
	
public static $zipfile;

function __construct() {
	if (file_exists(system."/external/pclzip.lib.php")) {
		require_once(system."/external/pclzip.lib.php");
		eval(self::zip());
		eval(self::addToZip());
	}
}

public static function makeZip($path){
	self::$zipfile=new PclZip($path);		
}

public static function addFilesToZip($files,$folder=null){
	if ($folder) {
		self::$zipfile->add($files,PCLZIP_OPT_REMOVE_PATH,$folder);
	} else {
		self::$zipfile->add($files,PCLZIP_OPT_REMOVE_ALL_PATH);
	}
}
                         
function zip(){ $s="";
	$s.='function zip($path){';
	$s.='plZip::makeZip($path);';
	$s.='}';
	return $s;
}

function addToZip(){ $s="";
	$s.='function addToZip($files,$folder=null){';
	$s.='plZip::addFilesToZip($files,$folder);';
	$s.='}';
	return $s;
}


} ?>
