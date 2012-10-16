<?php class plParser extends sn {
	
public static $parser;

function __construct() {
	if (file_exists(system."/external/simple_html_dom.php")) {
		require_once(system."/external/simple_html_dom.php");
		self::$parser=new simple_html_dom();
	}
}

} ?>
