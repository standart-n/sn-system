<?php class plProject extends sn {

function __construct() {
	if (file_exists(project."/controls/start.php")) {
		require_once(project."/controls/start.php");
		sn::cl("start");
	}
}

} ?>
