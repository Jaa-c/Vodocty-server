<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Parsujeme :)
 * 
 * @package vodocty.web.parsers
 */
class At_tirol_parser extends AbstractParser {
	
	//hodne nesystémový...
	private $ignore = array("Isel", "Schwarzach"); //I have better source (tirol_json)
	
	
	protected function parseData() {		
		$dom = new DomDocument();
		$dom->loadHTML($this->html);
				
		$xpath = new DOMXPath($dom);
		$tags = $xpath->query("//table/tr[position()>1]");

		$tempDom = new DomDocument();
		foreach ($tags as $tag) {
			$limnigraf = new Limnigraf();
			$tempDom->loadHTML(self::$zlo . $tag->C14N());
			$xp = new DOMXPath($tempDom);
			
			if($xp->query("//td[2][contains(concat(' ', @class, ' '), ' table1 ')]")->item(0)->nodeValue == NULL) continue;
	
			$limnigraf->setRiver($xp->query("//td[2][contains(concat(' ', @class, ' '), ' table1 ')]")->item(0)->nodeValue);
			if(in_array($limnigraf->getRiver(), $this->ignore)) continue;
				
			$limnigraf->setName($xp->query("//td[1][contains(concat(' ', @class, ' '), ' table1 ')]")->item(0)->nodeValue);
							
			$limnigraf->setHeight($xp->query("//td[4][contains(concat(' ', @class, ' '), ' table1 ')]")->item(0)->nodeValue);
			$limnigraf->setVolume($xp->query("//td[5][contains(concat(' ', @class, ' '), ' table1 ')]")->item(0)->nodeValue);
			
			$limnigraf->setDate(strtotime($xp->query("//td[3][contains(concat(' ', @class, ' '), ' table1 ')]")->item(0)->nodeValue));
			
			$this->data[] = $limnigraf;
		}
	}
 }

 ?>
