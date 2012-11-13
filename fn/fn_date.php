<? class fn_date {

function setDate($k,$type="day-month") { $s=""; $m=0; $mn=""; $i=0;
	$dt=explode(" ",$k); $d=$dt[0]; $d=str_replace(".","-",$d); $d=str_replace(".","-",$d);
	$di=explode("-",$d); $y=$di[0];
	if (isset($di[1])) { $m=intval($di[1]); }
	if (isset($di[2])) { $i=intval($di[2]); }
	switch ($m) {
		case 1: $mn="янв"; break;
		case 2: $mn="фев"; break;
		case 3: $mn="мар"; break;
		case 4: $mn="апр"; break;
		case 5: $mn="мая"; break;
		case 6: $mn="июня"; break;
		case 7: $mn="июля"; break;
		case 8: $mn="авг"; break;
		case 9: $mn="сен"; break;
		case 10: $mn="окт"; break;
		case 11: $mn="ноя"; break;
		case 12: $mn="дек"; break;
	}
	if ($i==0) { $i=""; }
	switch ($type) {
		case "day-month": 			$s=trim($i." ".$mn); break;
		case "day-month-year": 		$s=trim($i." ".$mn." ".$y); break;
	}
	if ($s=="") { $s="-"; }
	return $s;
}

}
