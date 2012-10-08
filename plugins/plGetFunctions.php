<?php class plGetFunctions extends sn {
	
function __construct() {
	if (isset(sn::$conf->functions)) { $data=sn::$conf->functions;
		foreach ($data as $key) {
			foreach ($key as $m) {
				if (file_exists(system."/fn/".$m.".php")) {
					require_once(system."/fn/".$m.".php");
					sn::cl($m);
				}
			}
		}
	}
}

} ?>
