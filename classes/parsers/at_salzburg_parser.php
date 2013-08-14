<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Parsujeme :)
 * 
 * @package vodocty.web.parsers
 */
class At_salzburg_parser extends AbstractParser {
	
	protected function parseData() {		
		$dom = new DomDocument();
		$dom->loadHTML($this->html);
		
		$xpath = new DOMXPath($dom);
		$tags = $xpath->query("//table[@class='parlist_table']/tr[position()>1]");
		
		$tempDom = new DomDocument();
		foreach ($tags as $tag) {
			$limnigraf = new Limnigraf(); 
			$tempDom->loadHTML($tag->C14N());
			$xp = new DOMXPath($tempDom);
					
			$limnigraf->setRiver($xp->query("//td[2]")->item(0)->nodeValue);
			$limnigraf->setName($xp->query("//td[1]")->item(0)->nodeValue);
			
			//if(is_numeric(trim($state->item(0)->nodeValue))) //todo
				//$limnigraf->setFlood($state->item(0)->nodeValue);
				
			preg_match('/[0-9]*/', $xp->query("//td[4]")->item(0)->nodeValue, $height);
			$limnigraf->setHeight($height[0]);
			preg_match('/[0-9\,]*/', $xp->query("//td[6]")->item(0)->nodeValue, $volume);
			$limnigraf->setVolume($volume[0]);
			
			$limnigraf->setDate(strtotime(str_replace("-", ".", $xp->query("//td[3]")->item(0)->nodeValue)));
			
			$this->data[] = $limnigraf;
		}
	}
 }

 ?>
