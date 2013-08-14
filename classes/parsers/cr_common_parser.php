<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Parsujeme :)
 * 
 * @package vodocty.web.parsers
 */
class Cr_common_parser extends AbstractParser {
	
	protected function parseData() {		
		$dom = new DomDocument();
		$dom->loadHTML(self::$zlo . substr($this->html, 1601));
				
		$xpath = new DOMXPath($dom);
		$tags = $xpath->query("//map//area");
		
		$tempDom = new DomDocument();
		foreach ($tags as $tag) {

			$limnigraf = new Limnigraf(); 
			
			$data = $tag->attributes->item(6)->nodeValue;
		
			preg_match_all("/'([^']*)'/", $data, $matches);
			
			$limnigraf->setRiver($matches[1][1]);
			$limnigraf->setName($matches[1][0]);
			
			preg_match("/[0-9]/", $matches[1][2], $flood);
			if(is_numeric($flood[0][0]))
				$limnigraf->setFlood($flood[0][0]);
				
			$limnigraf->setHeight($matches[1][4]);
			$limnigraf->setVolume($matches[1][5]);
			
			$limnigraf->setDate(strtotime(str_replace("-", ".", $matches[1][3]))); //14.08.2013 20:00
			
			$this->data[] = $limnigraf;
		}
	}
 }

 ?>