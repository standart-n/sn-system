<?php class plProject extends sn {

function __construct() {
	if (!isAjax()) {
		load("index.html");
		if (file_exists(project."/controls/start.php")) {
			require_once(project."/controls/start.php");
			sn::cl("start");
		}
	} else {
		if (file_exists(project."/controls/ajax.php")) {
			require_once(project."/controls/ajax.php");
			sn::cl("ajax");
		}
	}
}

} ?>
