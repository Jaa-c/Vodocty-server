<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Parsujeme :)
 * 
 * @package vodocty.web.parsers
 */
class Ch_common_parser extends AbstractParser {
	
	protected function parseData() {		
		$dom = new DomDocument();
		$dom->loadHTML($this->html);
		
		$xpath = new DOMXPath($dom);
		$tags = $xpath->query("//table[@id='mainStationList']/tr[position()>1]");
		
		$tempDom = new DomDocument();
		foreach ($tags as $tag) {
			$limnigraf = new Limnigraf(); 
			$tempDom->loadHTML(self::$zlo . $tag->C14N());
			$xp = new DOMXPath($tempDom);
			
			if(trim($xp->query("//td[2]")->item(0)->nodeValue) != "m3/s") continue;
			
			$name = $xp->query("//th")->item(0)->nodeValue;
			list($river, $lg) = explode('-', $name);
					
			$limnigraf->setRiver(trim($river));
			$limnigraf->setName(trim($lg));
			
			$limnigraf->setHeight(-1); //unavaiable
			
			$limnigraf->setVolume($xp->query("//td[3]")->item(0)->nodeValue);
			
			$limnigraf->setDate(strtotime(str_replace('.', '-', str_replace("\xc2\xa0", ' ', $xp->query("//td[1]")->item(0)->nodeValue))));
			
			$this->data[] = $limnigraf;
		}
	}
 }

 ?>
