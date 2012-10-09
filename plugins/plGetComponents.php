<?php class plGetComponents {

function __construct() {
	if (isset(sn::$conf->components)) {
		foreach (sn::$conf->components as $key) {
			if (isset($key->ajax)) {
				foreach ($key->ajax as $m) {
					echo $m;
					//if (!$q->base->ajax($q,$m)) { 
					//}
				}
			}
			if (isset($key->controls)) {
				foreach ($key->controls as $m) {
					if (!$q->base->controls($q,$m)) { 
						echo $m;
					}
				}
			}
		}
	}
	
}

}
