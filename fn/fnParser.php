<? class fnParser extends sn {

function __construct() {
	eval('function load($html) { return fnParser::load($html); }');
	eval('function html() { return fnParser::html(); }');
	eval('function innerHTML($selector,$html=null) { return fnParser::innerHTML($selector,$html); }');
}

public static function load($html) {
	if ($html=="index.html") {
		if (file_exists(project."/".$html)) {
			$f=@file_get_contents(project."/".$html);
			if (isset($f)) { if ($f!="") {
				return plParser::$parser->load($f);
			} }
		}
	}
	if (preg_match("/\.tpl$/i",$html)) {
		if (file_exists(project."/tpl/templates/".$html)) {
			$f=@file_get_contents(project."/tpl/templates/".$html);
			if (isset($f)) { if ($f!="") {
				return plParser::$parser->load($f);
			} }
		}
	}
	return plParser::$parser->load($html);
}

public static function html() {
	return plParser::$parser->save();
}

public static function innerHTML($selector,$html=null) {
	if ($html){
		if (preg_match("/\.tpl$/i",$html)) {
			if (file_exists(project."/tpl/templates/".$html)) {
				$f=@file_get_contents(project."/tpl/templates/".$html);
				if (isset($f)) { if ($f!="") {
					plParser::$parser->find($selector,0)->innertext=$f;
					plParser::$parser->load(plParser::$parser->save());
					return true;
				} }
			}
		}
		plParser::$parser->find($selector,0)->innertext=$html;
		plParser::$parser->load(plParser::$parser->save());
	} else {
		return plParser::$parser->find($selector,0)->innertext;
	}
}

} ?>
