<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Trida zobsahujici adresy zdroju
 * 
 * @package vodocty.web 
 */
class Feeds  {
	private static $feeds = array(
		'cz' => array(
			//"cr_vltava_parser" => array("/home/jaa/localhost/vodocty/temp/vltava.html", "windows-1250"),
			//"cr_ohre_parser" => array("/home/jaa/localhost/vodocty/temp/ohre.htm", "windows-1250"),
			//"cr_morava_parser" => array("/home/jaa/localhost/vodocty/temp/morava.htm", "windows-1250"),
			//"cr_labe_parser" => array("/home/jaa/localhost/vodocty/temp/labe.html", "utf-8"),
			//"cr_vltava_parser" => array("http://www.pvl.cz/portal/sap/cz/mapa_vse.htm", "windows-1250"),
			//"cr_labe_parser" => array("http://www.pla.cz/portal/sap/PC/", "windows-1250"),
			//"cr_ohre_parser" => array("http://www.poh.cz/portal/sap/cz/mapa_vse.htm", "windows-1250"),
			//"cr_morava_parser" => array("http://www.pmo.cz/portal/sap/cz/mapa_vse.htm", "utf-8"),
			"cr_common_parser" => array("http://hydro.chmi.cz/hpps/index.php", "windows-1250"),
		)
	);
	
	
	public static function getFeeds() {
		return self::$feeds;
	}
 }

 ?>
