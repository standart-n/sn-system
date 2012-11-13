<?php class plProject extends sn {

function __construct() {
	if ((isAjax()) && (file_exists(project."/controls/ajax.php"))) {
		require_once(project."/controls/ajax.php");
		sn::cl("ajax");
	} else {
		if (file_exists(project."/index.html")) {
			load("index.html");
		}
		if (file_exists(project."/controls/start.php")) {
			require_once(project."/controls/start.php");
			sn::cl("start");
		}
	}
}

} ?>
