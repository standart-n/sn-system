<?php class pl_baseMySQL {

function engine(&$q) {
	if ((isset($q->mysql->host)) && (isset($q->mysql->login)) && (isset($q->mysql->password)) && (isset($q->mysql->dbname))) {
		if (($q->mysql->host!="") && ($q->mysql->login!="") && ($q->mysql->password!="") && ($q->mysql->dbname!="")) {
			$q->mysql=new mysqli($q->mysql->host,$q->mysql->login,$q->mysql->password,$q->mysql->dbname);
			$q->mysql->query('SET NAMES UTF8');
		}
	}
}

} ?>
