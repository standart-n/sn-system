<?php class fnValidate extends sn {
	
function __construct() {
	eval('function toUTF($s) { return fnValidate::toUTF($s); }');
	eval('function toWIN($s) { return fnValidate::toWIN($s); }');
}

public static function toUTF($a) { $s="";
	$s.=iconv("cp1251","UTF-8",$a);
	return $s;
}

public static function toWIN($a) { $s="";
	$s.=iconv("UTF-8","cp1251",$a);
	return $s;
}

function idForSql(&$id) {
	$id=intval($id); if ($id<1) { $id=1; }
}

function skipForSql(&$id) {
	$id=intval($id); if ($id<0) { $id=0; }
}



function delSqlWords($a) { $s=$a;
	foreach (array("insert","delete","from","update","into","where","drop","dump","select","\*","\;") as $key) {
		$s=preg_replace("/".$key."/i","",$s);
	}
	return $s;
}

function urlInt(&$id) {
	$id=intval(trim(self::rmTags($id)));	
}

function urlStr(&$s) {
	$s=trim(strval($s));
	$s=stripslashes($s);
	$s=self::rmTags($s);
	$s=self::delSqlWords($s);
	if (strlen($s)>255) { $s=substr($s,0,255); }	
}

function urlQuery(&$s) {
	$s=trim(strval($s));
	$s=stripslashes($s);
	$s=self::rmTags($s);
	if (strlen($s)>999) { $s=substr($s,0,999); }	
}

function checkName($s,&$e){ $check=false; $e="";
	if ($s!="") {
		if ((strlen($s)>3) && (strlen($s)<30)) { 
			if (sizeof(explode(" ",trim($s)))<2) {
				if (preg_match("/[^a-z0-9\.\,\"\?\!\;\:\#\$\%\&\(\)\*\+\-\/\<\>\=\@\[\]\\\^\_\{\}\|\~]+/i",$s)) {
					$check=true;
				} else { $e="введенное значение некорректно"; }
			} else { $e="значение должно состоять из одного слова"; }
		} else { $e="введенное значение некорректно"; }
	} else { $e="вы ничего не ввели"; }
	if ($check) { $e="поле обязательно для заполнения"; }
	return $check;
}

function checkPhone($s,&$e){ $check=false; $e="";
	if ($s!="") {
		if ((strlen($s)>3) && (strlen($s)<30)) {
			if (preg_match("/\+?\d{1,3}(?:\s*\(\d+\)\s*)?(?:(?:\-\d{1,3})+\d|[\d\-]{6,}|(?:\s\d{1,3})+\d)/i",$s)) {
				$check=true;
			} else { $e="введенное значение некорректно"; }
		} else { $e="введенное значение некорректно"; }
	} else { $e="вы ничего не ввели"; }
	if ($check) { $e="поле обязательно для заполнения"; }
	return $check;
}


function checkEmail($s,&$e){ $check=false; $e="";
	if ($s!="") {
		if ((strlen($s)>3) && (strlen($s)<30)) {
			if (sizeof(explode(" ",trim($s)))<2) {
				if (preg_match("/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/i",$s)) {
					$check=true;
				} else { $e="введенное значение некорректно"; }
			} else { $e="e-mail адрес не должен содержать пробелы"; }
		} else { $e="введенное значение некорректно"; }
	} else { $e="вы ничего не ввели"; }
	if ($check) { $e="поле обязательно для заполнения"; }
	return $check;
}

} ?>
