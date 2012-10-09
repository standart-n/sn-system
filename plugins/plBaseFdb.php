<?php class plBaseFdb extends sn {
	
public static $cn;

function __construct() {
	self::$cn=new def;
	if (isset(sn::$conf->database)) { $data=sn::$conf->database;
		if (isset($data->connections)) {
			foreach ($data->connections as $alias=>$ms){
				if (isset($ms->type)) {
					if (($ms->type=="firebird") || ($ms->type=="fb")) { 
						$ms->type="firebird";
						self::$cn->$alias=new def;
						self::$cn->$alias->type=$ms->type;
						if (isset($ms->charset)) { self::$cn->$alias->charset=$ms->charset; }
						if ((isset($ms->path)) && (isset($ms->login)) && (isset($ms->password))) {
							if (($ms->path!="") && ($ms->login!="") && ($ms->password!="")) {
								self::$cn->$alias->db=@ibase_connect($ms->path,$ms->login,$ms->password);
								if (isset($ms->transactions)) {
									foreach ($ms->transactions as $it_alias=>$it) {
										self::$cn->$alias->$it_alias=@ibase_trans(IBASE_WRITE+IBASE_COMMITTED+IBASE_REC_VERSION+IBASE_NOWAIT,self::$cn->$alias->db);
									}
								}
							}
						}
					}
				}
			}
		}
	}
}

} ?>
