<?php class pl_alphaMobile {

function engine(&$q) {
	if (!$q->ajax) {
		$headers='';
		foreach ($_SERVER as $key => $value) {
			if (strpos($key,'HTTP_') === 0 && $key != 'HTTP_HOST' && $key != 'HTTP_CONNECTION') {
				$key = strtolower(strtr(substr($key, 5), '_', '-'));
				$headers.=$key.': '.$value."\r\n";
			}
		}
		$opts = array(
			'http'=>array(
			'method'=>"GET",
			'header'=> $headers,
			)
		);
		$sh=file_get_contents('http://phd.yandex.net/detect',false,stream_context_create($opts));	
	}
}

} ?>
