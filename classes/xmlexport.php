<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * exportujeme :)
 * 
 * @package vodocty.web 
 */
class XMLExport  {
	
	const RIVER = 'river';
	const LG = 'lg';
	const DATE = 'date';
	const HEIGHT = 'height';
	const VOLUME = 'volume';
	const FLOOD = 'flood';
	const NAME = 'name';
	
	
	private $result;
	
	function __construct($rivers, $prevRivers) {
		$this->result = "<?xml version='1.0' encoding='utf-8' ?>\n<data>\n";
		
		foreach($rivers as $river => $lgs) {
			$i = 0;
			$tempString = "\t<".self::RIVER." name='" . $river. "'>\n";
			foreach($lgs as $index => $lg) {
				//add only new data
				if(isset($prevRivers[$river][$index]) AND  $lg == $prevRivers[$river][$index]) {
					continue;
				}
				$i++;
				$tempString .= "\t\t<".self::LG." ".self::NAME."='" . $lg->getName() . "'>\n";
				$tempString .= "\t\t\t<".self::DATE.">" . $lg->getDate() . "</".self::DATE.">\n";
				$tempString .= "\t\t\t<".self::HEIGHT.">" . $lg->getHeight() . "</".self::HEIGHT.">\n";
				$tempString .= "\t\t\t<".self::VOLUME.">" . $lg->getVolume() . "</".self::VOLUME.">\n";
				if($lg->getFlood() != 0)
					$tempString .= "\t\t\t<".self::FLOOD.">" . $lg->getFlood() . "</".self::FLOOD.">\n";
				$tempString .= "\t\t</".self::LG.">\n";
			}
			$tempString .= "\t</".self::RIVER.">\n";
			if($i > 0) {
				$this->result .= $tempString;
			}
		}
		$this->result .= "</data>\n";
	}
	
	
	public function save($file) {
		if(strlen($this->result) < 60) {
			echo "no new data";
			return false;
		}
		
		$name = DATA_FOLDER . $file . '.xml.gz';
		var_dump(file_put_contents('compress.zlib://' . $name, $this->result));
		echo 'created: ' . $name . "\n";
		return true;
	}
 }

 ?>
