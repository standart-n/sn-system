<? class fnQuery extends sn {

function __construct() {
	eval('function query($a,&$r="") { return fnQuery::query($a,$r); }');
}

function query($a,&$r="") { $ms=array();
	if (is_array($a)) { $ms=$a; $sql=$a["sql"]; } else { $ms["sql"]=$a; $sql=$a; }
	switch (strtolower(substr($sql,0,6))) {
		case "select": return self::execQuery("select",$ms,$r); break;
		case "update": return self::execQuery("update",$ms,$r); break;
		case "insert": return self::execQuery("insert",$ms,$r); break;
		case "delete": return self::execQuery("delete",$ms,$r); break;
		default: return false;
	}
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
		plDataBase::commitIt($fb);
	} }
	$r=$rt;
	return $rt;
}

function fbInsert($fb,&$r="") { $rt=false;
	$query=@ibase_query(plDataBase::$cn->$fb["cn"]->$fb["it"],$fb["sql"]);
	if (isset($query)) { if ($query) { 
		$rt=true;
		plDataBase::commitIt($fb);
	} }
	$r=$rt;
	return $rt;
}

function fbDelete($fb,&$r="") { $rt=false;
	$query=@ibase_query(plDataBase::$cn->$fb["cn"]->$fb["it"],$fb["sql"]);
	if (isset($query)) { if ($query) { 
		$rt=true;
		plDataBase::commitIt($fb);
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
	if ($fb["clt"]=="auto") {
		if (sizeof($ms)==1) { $r=$ms[0]; } else { $r=$ms; }
	}
	if ($fb["clt"]=="array") {
		$r=$ms;
	}
	if ($fb["clt"]=="row") {
		$r=$ms[0];
	}
	return $rt;
}







function mysqlUpdate($a,&$r="") { $rt=false;
	$query=@mysql_query($a["sql"],plDataBase::$cn->$a["cn"]->db);
	if (isset($query)) { if ($query) { 
		$rt=true;
	} }
	$r=$rt;
	return $rt;
}

function mysqlInsert($a,&$r="") { $rt=false;
	$query=@mysql_query($a["sql"],plDataBase::$cn->$a["cn"]->db);
	if (isset($query)) { if ($query) { 
		$rt=true;
	} }
	$r=$rt;
	return $rt;
}

function mysqlDelete($a,&$r="") { $rt=false;
	$query=@mysql_query($a["sql"],plDataBase::$cn->$a["cn"]->db);
	if (isset($query)) { if ($query) { 
		$rt=true;
	} }
	$r=$rt;
	return $rt;
}

function mysqlSelect($a,&$r="") { $rt=false; $ms=array();
	$query=@mysql_query($a["sql"],plDataBase::$cn->$a["cn"]->db);
	if (isset($query)) { if ($query) { $rt=true;
		if ($a["get"]=="object") {
			while ($line=mysql_fetch_object($query)) {
				if (isset($line)) {
					if (is_object($line)) {
						$ms[]=$line;
						if (sizeof($ms)>=$a["limit"]) break;
					}
				}
			}
		}
		if ($a["get"]=="array") {
			while ($line=mysql_fetch_array($query)) {
				if (isset($line)) {
					if (is_array($line)) {
						$ms[]=$line;
						if (sizeof($ms)>=$a["limit"]) break;
					}
				}
			}
		}
	} }
	if ($a["clt"]=="auto") {
		if (sizeof($ms)==1) { $r=$ms[0]; } else { $r=$ms; }
	}
	if ($a["clt"]=="array") {
		$r=$ms;
	}
	if ($a["clt"]=="row") {
		$r=$ms[0];
	}
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

		if (isset($ms["collection"])) {
			if (in_array($ms["collection"],array("auto","array","row"))) {
				$clt=$ms["collection"];
			}
		}
		if (!isset($clt)) { 
			if (isset(sn::$conf->database->settings->collection_of_data_return)) {
				$clt=sn::$conf->database->settings->collection_of_data_return;
			}
		}
		if (!isset($clt)) {
			$clt="auto";
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
								case "select": $rt=self::fbSelect(array("cn"=>$connnect,"it"=>$it,"sql"=>$sql,"get"=>$get,"clt"=>$clt,"limit"=>$limit),$r); break;
								case "update": $rt=self::fbUpdate(array("cn"=>$connnect,"it"=>$it,"sql"=>$sql),$r); break;
								case "insert": $rt=self::fbInsert(array("cn"=>$connnect,"it"=>$it,"sql"=>$sql),$r); break;
								case "delete": $rt=self::fbSelect(array("cn"=>$connnect,"it"=>$it,"sql"=>$sql),$r); break;
							}
						}
					}
				}
			}


			if ($type=="mysql") {
				if (isset(plDataBase::$cn->$connnect)) {
					if (isset(plDataBase::$cn->$connnect->db)) {
						switch ($method) {
							case "select": $rt=self::mysqlSelect(array("cn"=>$connnect,"sql"=>$sql,"get"=>$get,"clt"=>$clt,"limit"=>$limit),$r); break;
							case "update": $rt=self::mysqlUpdate(array("cn"=>$connnect,"sql"=>$sql),$r); break;
							case "insert": $rt=self::mysqlInsert(array("cn"=>$connnect,"sql"=>$sql),$r); break;
							case "delete": $rt=self::mysqlSelect(array("cn"=>$connnect,"sql"=>$sql),$r); break;
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
													$connect=$ms_cn;
													$it=$it_alias;
												}
											}
										}
									}
								}
							}
						}


						if (plDataBase::$cn->$fb["cn"]->type=="mysql") {
							if (isset(sn::$conf->database->connections->$ms_cn)) {
								$type="mysql";
								$connect=$ms_cn;
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


							if (plDataBase::$cn->$de_cn->type=="mysql") {
								if (isset(sn::$conf->database->connections->$de_cn)) {
									$type="mysql";
									$connect=$de_cn;
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

} ?>
