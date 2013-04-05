<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * nacitame :)
 * 
 * @package vodocty.web 
 */
class Loader  {
	private $feeds;
	private $result;
	
	function __construct($feeds) {
		$this->feeds = $feeds;
		$this->result = array();
	}
	/**
	* nacte data z parseru do vystupni promenny $rivers
	* array rivers - vysputni parametr s rekama
	*/
	public function load(&$rivers) {
		foreach($this->feeds as $parser => $data) {
			$parser = ucfirst($parser);
			$p = new $parser($data[0], $data[1]); //$p je AbstractParser			
			
			foreach($p->getData() as $limnigraf) {
				//if(array_key_exists($limnigraf->getName(), $rivers[$limnigraf->getRiver()])) {
					//prodat podminku jestli je tam i limnigraf - vice parseru na stejne reky
				//	$rivers[$limnigraf->getRiver()] = array();
				//}
				$rivers[$limnigraf->getRiver()][$limnigraf->getName()] = $limnigraf;
			}
		}
	
	}
 }

 ?>
