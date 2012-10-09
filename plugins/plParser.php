<?php class plParser extends sn {
	
public static $parser;

function __construct() {
	if (file_exists(system."/external/simple_html_dom.php")) {
		require_once(system."/external/simple_html_dom.php");
		self::$parser=new simple_html_dom();
		eval(self::load());
		eval(self::html());
		eval(self::innerHTML());
	}
}

function load(){ $s="";
	$s.='function load($html){';
	$s.='return plParser::$parser->load($html);';
	$s.='}';
	return $s;
}

function html(){ $s="";
	$s.='function html(){';
	$s.='return plParser::$parser->save();';
	$s.='}';
	return $s;
}

function innerHTML(){ $s="";
	$s.='function innerHTML($selector,$html=null){';
	$s.='if ($html){';
	$s.=	'plParser::$parser->find($selector,0)->innertext=$html;';
	$s.=	'plParser::$parser->load(plParser::$parser->save());';
	$s.=	'return true;';
	$s.='} else {';
	$s.=	'return plParser::$parser->find($selector,0)->innertext;';
	$s.='}';
	$s.='}';
	return $s;
}

} ?>
