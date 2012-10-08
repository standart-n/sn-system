<?php class fn_mail {
 
function send($q,$to="",$subject="",$body="",$from="") { $send=false; $lib=false;

	if (isset($q->mail->lib)) {
		if (file_exists($q->mail->lib)) {
			require_once $q->mail->lib;
			$lib=true;
		}
	} 
	if (($from=="") && (isset($q->mail->box))) { $from=$q->mail->box; }
	$to="<".$to.">";
	$from="<".$from.">";
		
	$headers=array('From'=>$from,'To'=>$to,'Subject'=>$subject);
	if ($lib) {
		if ((isset($q->mail->host)) && (isset($q->mail->port)) && (isset($q->mail->login)) && (isset($q->mail->password))) {
			$smtp=Mail::factory('smtp',
						array (	'host' => $q->mail->host,
								'port' => $q->mail->port,
								'auth' => true,
								'username' => $q->mail->login,
								'password' => $q->mail->password
							  )
						);
			$mail=$smtp->send($to,$headers,$body);
			if (PEAR::isError($mail)) {
				//echo("<p>".$mail->getMessage()."</p>");
			} else {
				$send=true;
			}
		}
	}
	return $send;
}

} ?>
