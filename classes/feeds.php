<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Trida zobsahujici adresy zdroju
 * 
 * @package vodocty.web 
 */
class Feeds  {
	
	/* POZOR - pokud jsou ve vice parserech v ramci statu stejné řeky, pozdější link přepíše ten dřívější (by design) */
	private static $feeds = array(
		'at' => array(
			"at_steiermark_parser" => array(
				array(
					"http://app.hydrographie.steiermark.at/bilder/Hochwasserzentrale/PNG_Online_Pub/Q.js", 
					"http://app.hydrographie.steiermark.at/bilder/Hochwasserzentrale/PNG_Online_Pub/W.js"
				), "utf-8"),
			"at_tirol_json_parser" =>array("https://apps.tirol.gv.at/hydro/stationdata/data.json", "utf-8"),
			"at_salzburg_parser" => array("http://www.salzburg.gv.at/wasserwirtschaft/6-64-seen/hdweb/pegelstand.html", "utf-8"),
			"at_tirol_parser" => array("https://info.ktn.gv.at/asp/hydro/daten/Tabelle_Abfluss.html", "ISO-8859-1"),
			"at_common_parser" => array("http://ehyd.gv.at/eHYD/PegelAktuell", "utf-8"),
			),
		'ch' => array(
			"ch_common_parser" => array("http://www.hydrodaten.admin.ch/de/", "utf-8"),			
			),
		'cz' => array(
			//"cr_vltava_parser" => array("http://www.pvl.cz/portal/sap/cz/mapa_vse.htm", "windows-1250"),
			//"cr_labe_parser" => array("http://www.pla.cz/portal/sap/PC/", "windows-1250"),
			//"cr_ohre_parser" => array("http://www.poh.cz/portal/sap/cz/mapa_vse.htm", "windows-1250"),
			//"cr_morava_parser" => array("http://www.pmo.cz/portal/sap/cz/mapa_vse.htm", "utf-8"),
			"cr_common_parser" => array("http://hydro.chmi.cz/hpps/index.php", "windows-1250"),
			),
	);
	
	
	public static function getFeeds() {
		return self::$feeds;
	}
 }

 ?>
