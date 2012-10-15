<? class fnQuery extends sn {

function __construct() {
	eval(self::query());
}

function select($a,&$r="") { $ms=array();
	if (is_array($a)) { $ms=$a; } else { $ms["sql"]=$a; }
	return self::execQuery("select",$ms,$r);
}

function update($a,&$r="") { $ms=array();
	if (is_array($a)) { $ms=$a; } else { $ms["sql"]=$a; }
	return self::execQuery("update",$ms);
}

function insert($a,&$r="") { $ms=array();
	if (is_array($a)) { $ms=$a; } else { $ms["sql"]=$a; }
	return self::execQuery("insert",$ms);
}

function delete(&$a,&$r="") { $ms=array();
	if (is_array($a)) { $ms=$a; } else { $ms["sql"]=$a; }
	return self::execQuery("delete",$ms);
}



function fbUpdate($fb,&$r="") { $rt=false;
	$query=@ibase_query(plDataBase::$cn->$fb["cn"]->$fb["it"],$fb["sql"]);
	if (isset($query)) { if ($query) { 
		$rt=true;
		//ibase_commit(plDataBase::$cn->$fb["cn"]->$fb["it"]);
		//plDataBase::$cn->$fb["cn"]->$fb["it"]=ibase_trans(IBASE_WRITE+IBASE_COMMITTED+IBASE_REC_VERSION+IBASE_NOWAIT,plDataBase::$cn->$fb["cn"]->db);
	} }
	$r=$rt;
	return $rt;
}

function fbInsert($fb,&$r="") { $rt=false;
	$query=@ibase_query(plDataBase::$cn->$fb["cn"]->$fb["it"],$fb["sql"]);
	if (isset($query)) { if ($query) { 
		$rt=true;
		//ibase_commit(plDataBase::$cn->$fb["cn"]->$fb["it"]);
		//plDataBase::$cn->$fb["cn"]->$fb["it"]=ibase_trans(IBASE_WRITE+IBASE_COMMITTED+IBASE_REC_VERSION+IBASE_NOWAIT,plDataBase::$cn->$fb["cn"]->db);
	} }
	$r=$rt;
	return $rt;
}

function fbDelete($fb,&$r="") { $rt=false;
	$query=@ibase_query(plDataBase::$cn->$fb["cn"]->$fb["it"],$fb["sql"]);
	if (isset($query)) { if ($query) { 
		$rt=true;
		//ibase_commit(plDataBase::$cn->$fb["cn"]->$fb["it"]);
		//plDataBase::$cn->$fb["cn"]->$fb["it"]=ibase_trans(IBASE_WRITE+IBASE_COMMITTED+IBASE_REC_VERSION+IBASE_NOWAIT,plDataBase::$cn->$fb["cn"]->db);
	} }
	$r=$rt;
	return $rt;
}

function fbSelect($fb,&$r="") { $rt=false; $ms=array();
	$query=@ibase_query(plDataBase::$cn->$fb["cn"]->$fb["it"],$fb["sql"]);
	if (isset($query)) { if ($query) { $rt=true;
		if ($fb["get"]=="object") {
			while ($line=ibase_fetch_object($query)) {
				if (isset($line)) {
					if (is_object($line)) {
						$ms[]=$line;
						if (sizeof($ms)>=$fb["limit"]) break;
					}
				}
			}
		}
		if ($fb["get"]=="array") {
			while ($line=ibase_fetch_row($query)) {
				if (isset($line)) {
					if (is_array($line)) {
						$ms[]=$line;
						if (sizeof($ms)>=$fb["limit"]) break;
					}
				}
			}
		}
	} }
	if (sizeof($ms)==1) { $r=$ms[0]; } else { $r=$ms; }
	return $rt;
}

function execQuery($method,$ms,&$r="") { $a=array();
	if (in_array($method,array("select","insert","update","delete"))) {		
		$a=self::getConnection($ms);
		if (isset($a["type"])) { $type=$a["type"]; }
		if (isset($a["cn"])) { $connnect=$a["cn"]; }
		if (isset($a["it"])) { $it=$a["it"]; }
		if (isset($ms["sql"])) {
			if ($ms["sql"]!="") {
				$sql=$ms["sql"];
			}
		}
		if (isset($ms["get"])) {
			if (in_array($ms["get"],array("object","array"))) {
				$get=$ms["get"];
			}
		}
		if (!isset($get)) { 
			if (isset(sn::$conf->database->settings->type_of_data_return)) {
				$get=sn::$conf->database->settings->type_of_data_return;
			} else {
				$get="object";
			}
		}
		if (isset($ms["limit"])) {
			$limit=intval($ms["limit"]);
		}
		if (!isset($limit)) { 
			if (isset(sn::$conf->database->settings->limit_of_rows)) {
				$limit=sn::$conf->database->settings->limit_of_rows;
			} else {
				$limit=1000;
			}
		}
		if ((isset($connnect)) && (isset($type)) && (isset($sql))) {
			if ($type=="firebird") {
				if (isset($it)) {
					if (isset(plDataBase::$cn->$connnect)) {
						if ((isset(plDataBase::$cn->$connnect->$it)) && (isset(plDataBase::$cn->$connnect->db))) {
							switch ($method) {
								case "select": $rt=self::fbSelect(array("cn"=>$connnect,"it"=>$it,"sql"=>$sql,"get"=>$get,"limit"=>$limit),$r); break;
								case "update": $rt=self::fbUpdate(array("cn"=>$connnect,"it"=>$it,"sql"=>$sql),$r); break;
								case "insert": $rt=self::fbInsert(array("cn"=>$connnect,"it"=>$it,"sql"=>$sql),$r); break;
								case "delete": $rt=self::fbSelect(array("cn"=>$connnect,"it"=>$it,"sql"=>$sql),$r); break;
							}
						}
					}
				}
			}										
		}
	}
	if (!isset($rt)) { $rt=false; }
	return $rt;
}


function getConnection($ms){ $a=array();
	if (isset($ms["connection"])) {
		if ($ms["connection"]!="") { 
			$ms_cn=$ms["connection"];
			if (isset(plDataBase::$cn->$fb["cn"])) {
				if (isset(plDataBase::$cn->$fb["cn"]->db)) {
					if (isset(plDataBase::$cn->$fb["cn"]->type)) {
						
						if (plDataBase::$cn->$fb["cn"]->type=="firebird") {
							if (isset($ms["transaction"])) {
								$ms_it=$ms["transaction"];
								if (isset(plDataBase::$cn->$fb["cn"]->$ms_it)) {
									$type="firebird";
									$connect=$ms_cn;
									$it=$ms_it;
								}
							}
							if (!isset($it)) {
								if (isset(sn::$conf->database->connections->$ms_cn)) {
									if (isset(sn::$conf->database->connections->$ms_cn->transactions)) {
										foreach (sn::$conf->database->connections->$ms_cn->transactions as $it_alias=>$it_data) {
											if (!isset($it)) {
												if (isset(plDataBase::$cn->$fb["cn"]->$it_alias)) {
													$type="firebird";
													$cn=$ms_cn;
													$it=$it_alias;
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
		}
	}
	if (!isset($connect)) {
		if (isset(sn::$conf->database->default)) {
			if (isset(sn::$conf->database->default->connection)) {
				$de_cn=sn::$conf->database->default->connection;
				if (isset(plDataBase::$cn->$de_cn)) {
					if (isset(plDataBase::$cn->$de_cn->db)) {
						if (isset(plDataBase::$cn->$de_cn->type)) {
							if (plDataBase::$cn->$de_cn->type=="firebird") {
								if (isset(sn::$conf->database->default->transaction)) {
									$de_it=sn::$conf->database->default->transaction;
									if (isset(plDataBase::$cn->$de_cn->$de_it)) {
										$type="firebird";
										$connect=$de_cn;
										$it=$de_it;
									}
								}
								if (!isset($it)) {
									if (isset(sn::$conf->database->connections->$de_cn)) {
										if (isset(sn::$conf->database->connections->$de_cn->transactions)) {
											foreach (sn::$conf->database->connections->$de_cn->transactions as $it_alias=>$it_data) {
												if (!isset($it)) {
													if (isset(plDataBase::$cn->$de_cn->$it_alias)) {
														$type="firebird";
														$connect=$de_cn;
														$it=$it_alias;
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
			}			
		}		
	}
	if (isset($type)) { $a["type"]=$type; }
	if (isset($connect)) { $a["cn"]=$connect; }
	if (isset($it)) { $a["it"]=$it; }
	return $a;
}

function query() { $s="";
	$s.='function query($a,&$r=""){ $ms=array();';
	$s.='if (is_array($a)) { $ms=$a; $sql=$a["sql"]; } else { $ms["sql"]=$a; $sql=$a; }';
	$s.='switch (strtolower(substr($sql,0,6))){';
	$s.='case "select": return fnQuery::execQuery("select",$ms,$r); break;';
	$s.='case "update": return fnQuery::execQuery("update",$ms,$r); break;';
	$s.='case "insert": return fnQuery::execQuery("insert",$ms,$r); break;';
	$s.='case "delete": return fnQuery::execQuery("delete",$ms,$r); break;';
	$s.='}';
	$s.='}';
	return $s;
}

} ?>
