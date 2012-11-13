<?php class fn_models {

var $local="";

function onLoad(&$q) {
	eval($this->toModel());
}

function toModel() { $s="";
	$s.='function toModel(&$q,$s="",$tag="",$type="simple") {';
	$s.='	switch ($type) {';
	$s.='	case "simple":';
	$s.='		$q->html=str_replace("[".$tag."]",$s,$q->html);';
	$s.='	break;';
	$s.='	}';
	$s.='}';
	return $s;
}

function loadModel($q,$name) { $s="";
    $mdl=$this->local.'models/'.$q->folders->models.'/mdl_'.$name.'.html';
    if (file_exists($mdl)) { if (fopen($mdl,"r")) {
		$s=file_get_contents($mdl);
	}	}	
	return $s;
}

} ?>
