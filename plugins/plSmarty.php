<?php class plSmarty extends sn {
	
public static $smarty;

function __construct() {
	if (file_exists(system."/external/smarty/Smarty.class.php")) {

		define('SMARTY_DIR',system.'/external/smarty/');
		require(system."/external/smarty/Smarty.class.php");

		self::$smarty=new Smarty();
		self::$smarty->template_dir='tpl/templates/';
		self::$smarty->compile_dir='tpl/templates_c/';
		self::$smarty->config_dir='tpl/configs/';
		self::$smarty->cache_dir='tpl/cache/';

	}
}

} ?>
