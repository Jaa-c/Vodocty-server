<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Trida zobsahujici adresy zdroju
 * 
 * @package vodocty.web 
 */
class Feeds  {
	private static $feeds = array(
		"cr_vltava_parser" => array("/home/jaa/localhost/vodocty/temp/vltava.html", "windows-1250"),
		"cr_ohre_parser" => array("/home/jaa/localhost/vodocty/temp/ohre.htm", "windows-1250"),
		"cr_morava_parser" => array("/home/jaa/localhost/vodocty/temp/morava.htm", "windows-1250"),
		"cr_labe_parser" => array("/home/jaa/localhost/vodocty/temp/labe.html", "utf-8"),
		//"cr_vltava_parser" => "http://www.pvl.cz/portal/sap/cz/mapa_vse.htm",
		//"cr_labe_parser" => "http://www.pla.cz/portal/sap/PC/",
		//"cr_ohre_parser" => "http://www.poh.cz/portal/sap/cz/mapa_vse.htm",
		//"cr_morava_parser" => "http://www.pmo.cz/portal/sap/cz/mapa_vse.htm",
	);
	
	
	public static function getFeeds() {
		return self::$feeds;
	}
 }

 ?>
