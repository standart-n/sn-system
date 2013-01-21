<? class fnSmarty extends sn {

function __construct() {
	eval('function display($tpl) { return fnSmarty::display($tpl); }');
	eval('function fetch($tpl) { return fnSmarty::fetch($tpl); }');
	eval('function assign($tag,$value) { return fnSmarty::assign($tag,$value); }');
}

public static function display($tpl) {
	return plSmarty::$smarty->display($tpl);
}

public static function fetch($tpl) {
	return plSmarty::$smarty->fetch($tpl);
}

public static function assign($tag,$value) {
	return plSmarty::$smarty->assign($tag,$value);
}

} ?>
