<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Parsujeme :)
 * 
 * @package vodocty.web.parsers
 */
class Cr_vltava_parser extends AbstractParser {
	
	protected function parseData() {		
		$dom = new DomDocument();
		$dom->loadHTML($this->html);
		
		$xpath = new DOMXPath($dom);
		$tags = $xpath->query("//table[@border='1']");

		$tempDom = new DomDocument();
		foreach ($tags as $tag) {
			$limnigraf = new Limnigraf(); 
			$tempDom->loadHTML(self::$zlo . $tag->C14N());
			$xp = new DOMXPath($tempDom);
			
			$name = $xp->query("//font[@class='text1bold']");			
			$limnigraf->setRiver($name->item(0)->nodeValue);
			$limnigraf->setName($name->item(1)->nodeValue);
			
			$state = $xp->query("//table[@border='0']//font[@class='text1']/b");
			if(is_numeric(trim($state->item(0)->nodeValue)))
				$limnigraf->setFlood($state->item(0)->nodeValue);
			$limnigraf->setHeight($state->item(1)->nodeValue);
			$limnigraf->setVolume($state->item(2)->nodeValue);
			
			$state = $xp->query("//table[@border='0']//font[@class='text1']");
			$date = array();
			preg_match('/\((.*)\)/', $state->item(1)->nodeValue, $date);
			$limnigraf->setDate($date[1]);
			
			$this->data[] = $limnigraf;
		}
	}
 }

 ?>
