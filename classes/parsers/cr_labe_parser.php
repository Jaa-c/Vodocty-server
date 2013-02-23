<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Parsujeme :)
 * 
 * @package vodocty.web.parsers
 */
class Cr_labe_parser extends AbstractParser {
	
	protected function parseData() {		
		$dom = new DomDocument();
		$dom->loadHTML($this->html);
		
		$xpath = new DOMXPath($dom);
		$tags = $xpath->query("//table//input");
		
		foreach ($tags as $tag) {
			$limnigraf = new Limnigraf(); 
			$match = array();
			preg_match('/value="(.*)"/', $tag->C14N(), $match);
			
			$data = explode('|', $match[1]);
			
			$limnigraf->setRiver($data[0]);
			$limnigraf->setName($data[1]);
			$limnigraf->setFlood($data[12]);
			$limnigraf->setHeight($data[2]);
			$limnigraf->setVolume($data[3]);
			
			$date = array();
			preg_match('/\((.*)\)/', $data[4], $date);
			$limnigraf->setDate($date[1]);
			
			$this->data[] = $limnigraf;
		}
	}
	
 }

 ?>
