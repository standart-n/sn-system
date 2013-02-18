<?php
	const system="/var/web/st-n/_system/sn-project/sn-system";
	const project="/var/web/st-n/_system/sn-project";
	
	if (file_exists(system.'/core/sn.php')) {
		require_once(system.'/core/sn.php');
		$sn=new sn;
	}
?>
