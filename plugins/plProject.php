<?php class plProject extends sn {

function __construct() {
	if (file_exists(project."/controls/main.php")) {
		require_once(project."/controls/main.php");
		sn::cl("start");
	}
}

} ?>
