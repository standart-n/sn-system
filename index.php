<?php
	define("project",preg_replace('/\/([a-zA-Z0-9\.\-\!\~])+$/','/',$_SERVER['SCRIPT_FILENAME']));
	define("system",project."sn-system");
	define("core",system.'/core/sn.php');
	
	if (file_exists(core)) {
		require_once(core);
		$sn=new sn;
	} else {
		echo "not found ".core;
	}
?>
