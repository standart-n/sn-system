<?php class pl_modules { 
function engine() { $q=&$this->q; $html=""; $css="";
	if (isset($q->parsing)) { $q->parsing->load($q->html);
		chdir("./modules"); $dir=opendir(".");
			while ($d=readdir($dir)) { 
				if (is_dir($d)) { 
					if (($d!=".") && ($d!="..")) {
						$mdl=""; $nm=strval($d);
						if (file_exists($d."/".$d."_ico_48.png")) { $img_48="modules/".$d."/".$d."_ico_48"; } else { $img_48="img/".$q->folder."/system_ico_48"; }
						if (file_exists($d."/".$d."_ico_24.png")) { $img_24="modules/".$d."/".$d."_ico_24"; } else { $img_24="img/".$q->folder."/system_ico_24"; }
						if (file_exists($d."/".$d."_config.ini")) {
							$config=parse_ini_file($d."/".$d."_config.ini",true);
							while (list($option,$line)=each($config)) {
								while (list($field,$value)=each($line)) {
									$this->$field=trim($value);
									if (trim($field)=="name") { $name=$value; }
									if (isset($q->$name)) { $q->$name->$field=$value; }
								}
							}
							if (file_exists($d."/".$d."_script.js")) {
								if (isset($this->name)) { 
									//$mdl.='<script src="modules/'.$d.'/'.$d.'_script.js" type="text/javascript"></script>'; 
									$script=file_get_contents($d."/".$d."_script.js");
									$mdl.='<script type="text/javascript">';
									$mdl.=$script;
									$mdl.='</script>';
									$mdl.='<script type="text/javascript">';
									$mdl.='new '.$this->name.'({';
									while (list($key,$value)=each($q->$name)) {
										$mdl.=''.$key.':"'.$value.'",';
									}
									$mdl.='enable:true';
									$mdl.='});';
									$mdl.='</script>';
								}
							}
							if (file_exists($d."/".$d."_style.css")) {
									$style=file_get_contents($d."/".$d."_style.css");
									$css.=$style;
							}
							$mdl.='<div ';
							if (isset($this->name)) { $mdl.='window_name="'.$this->name.'" '; }
							$mdl.='window_type="icon" window_image="'.$img_48.'.png">';
							if (isset($this->caption)) { $mdl.=$this->caption.''; }
							$mdl.='</div>';
							$mdl.='<div ';
							if (isset($this->name)) { $mdl.='window_name="'.$this->name.'" '; }
							if (isset($this->caption)) { $mdl.='window_caption="'.$this->caption.'" '; }
							if (isset($this->top)) { $mdl.='window_top="'.$this->top.'" '; }
							if (isset($this->left)) { $mdl.='window_left="'.$this->left.'" '; }
							if (isset($this->width)) { $mdl.='window_width="'.$this->width.'" '; }
							if (isset($this->height)) { $mdl.='window_height="'.$this->height.'" '; }
							if (isset($this->min_width)) { $mdl.='window_min_width="'.$this->min_width.'" '; }
							if (isset($this->min_height)) { $mdl.='window_min_height="'.$this->min_height.'" '; }
							$mdl.='window_type="window" window_image="'.$img_24.'.png">';
							$mdl.='<div ';
							if (isset($this->name)) { $mdl.='window_name="'.$this->name.'" '; }
							$mdl.='window_type="top">';
							$mdl.='</div>';
							$mdl.='<div ';
							if (isset($this->name)) { $mdl.='window_name="'.$this->name.'" '; }
							$mdl.='window_type="content">';
							$mdl.='</div>';
							$mdl.='<div ';
							if (isset($this->name)) { $mdl.='window_name="'.$this->name.'" '; }
							$mdl.='window_type="bottom">';
							$mdl.='</div>';
							$mdl.='</div>';
							$html.=$mdl;
						}
					} 
				} 
			}
		closedir($dir); chdir(".."); $sh="";
		$css='<style type="text/css">'.$css.'</style>';
		$css=preg_replace("/url\(\.\.\/\.\.\//","url(",$css);
		$q->parsing->find("head",0)->innertext=$q->parsing->find("head",0)->innertext.$css;
			$q->parsing->load($q->parsing->save());
		$q->parsing->find("#desktop",0)->innertext=$q->parsing->find("#desktop",0)->innertext.$html;
			$q->parsing->load($q->parsing->save());
		$server=$_SERVER['SERVER_NAME']; $server="http://".$server;
		$script=$_SERVER['SCRIPT_NAME'];
		$path=$server.$script; $path=str_replace("/index.php","",$path);
		foreach (explode("|","server|script|path") as $key) {
			$sh.='<input type="hidden" id="sh_'.$key.'" value="'.$$key.'">';
		}
		$q->parsing->find("#shadow",0)->innertext=$q->parsing->find("#shadow",0)->innertext.$sh;
			$q->parsing->load($q->parsing->save());
		$q->html=$q->parsing->save();
		$q->html=preg_replace("/\<\/style\>\<style type\=\"text\/css\"\>/","",$q->html);
		
	}
    return $q;
}
} ?>
