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
			
			//if(is_numeric(trim($state->item(0)->nodeValue)))
			//	$limnigraf->setFlood($state->item(0)->nodeValue);
			$limnigraf->setHeight($matches[1][4]);
			$limnigraf->setVolume($matches[1][5]);
			
			$limnigraf->setDate($matches[1][3]);
			
			$this->data[] = $limnigraf;
		}
	}
 }

 ?>