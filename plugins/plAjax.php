<?php class plAjax extends sn {

public static $ajax=false;
public static $json=array();
public static $referer;

function __construct() { 
	if (isset($_SERVER["HTTP_X_REQUESTED_WITH"])) {
		if ($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest") { 
			self::$ajax=true;
		}
	}
	if (isset($_SERVER["HTTP_REFERER"])) {
		self::$referer=$_SERVER["HTTP_REFERER"];
	}
	eval("function isAjax(){return plAjax::\$ajax;}");
}

} ?>
