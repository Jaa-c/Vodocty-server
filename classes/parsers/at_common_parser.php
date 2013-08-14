<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * parsieren wir :)
 * 
 * @package vodocty.web.parsers
 */
class At_common_parser extends AbstractParser {
	
	protected function parseData() {		
		$dom = new DomDocument();
		//$dom->loadHTML(self::$zlo . $this->html);
		
		$dom->loadXML($this->html);
		
		$xpath = new DOMXPath($dom);
		$tags = $xpath->query("//ehyd:pegelaktuell");
		//var_dump($tags);
		//exit;
		
		$tempDom = new DomDocument();
		foreach ($tags as $tag) {

			$limnigraf = new Limnigraf(); 
			
			$tempDom->loadXML($tag->C14N());
			$xp = new DOMXPath($tempDom);
			
			if($xp->query("//ehyd:wert")->item(0) == NULL) { //no height
				continue;
			}
			
			$limnigraf->setRiver($xp->query("//ehyd:gewasser")->item(0)->nodeValue);
			$limnigraf->setName($xp->query("//ehyd:messstelle")->item(0)->nodeValue);
			
			//if(is_numeric(trim($state->item(0)->nodeValue)))
			//	$limnigraf->setFlood($state->item(0)->nodeValue);
			$limnigraf->setHeight(-1); // n/A
			$limnigraf->setVolume($xp->query("//ehyd:wert")->item(0)->nodeValue);
			
			$date = new DateTime( $xp->query("//ehyd:zp")->item(0)->nodeValue);
			
			$limnigraf->setDate($date->getTimestamp());
			
			$this->data[] = $limnigraf;
		}
	}
 }

 ?>