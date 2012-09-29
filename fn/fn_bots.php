<? class fn_bots {

function isBot(&$botname=''){
	if (!isset($_SERVER['HTTP_USER_AGENT'])) return false;
	if ($_SERVER['HTTP_USER_AGENT']=="") return false;
    $bots = array(
        'rambler','googlebot','aport','yahoo','msnbot','turtle','mail.ru','omsktele',
        'yetibot','picsearch','sape.bot','sape_context','gigabot','snapbot','alexa.com',
        'megadownload.net','askpeter.info','igde.ru','ask.com','qwartabot','yanga.co.uk',
        'scoutjet','similarpages','oozbot','shrinktheweb.com','aboutusbot','followsite.com',
        'dataparksearch','google-sitemaps','appEngine-google','feedfetcher-google',
        'liveinternet.ru','xml-sitemaps.com','agama','metadatalabs.com','h1.hrn.ru',
        'googlealert.com','seo-rus.com','yaDirectBot','yandeG','yandex',
        'yandexSomething','Copyscape.com','AdsBot-Google','domaintools.com',
        'Nigma.ru','bing.com','dotnetdotcom'
    );
    foreach($bots as $bot) {
        if(stripos($_SERVER['HTTP_USER_AGENT'],$bot)!==false){
			$botname=$bot;
			return true;
		}
	}
    return false;
}

} ?>
