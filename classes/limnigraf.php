<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Data z vodoctu
 * 
 * @package vodocty.web.parsers
 */
class Limnigraf  {
	private $river, $name, $date, $height, $volume, $floodLevel = 0;
	
	public function setRiver($river) {
		$this->river = $this->tri($river);
	}
	public function getRiver() {
		return $this->river;
	}
	
	public function setName($name) {
		$this->name = $this->tri($name);
	}
	public function getName() {
		return $this->name;
	}
	
	public function setDate($date) {
		$this->date = $this->tri($date);
	}
	public function getDate() {
		return $this->date;
	}
	
	public function setHeight($height) {
		$this->height = $this->tri($height);
	}
	public function getHeight() {
		return $this->height;
	}
	
	public function setVolume($volume) {
		$this->volume = str_replace(',', '.', $this->tri($volume));
		if(!is_numeric($this->volume))
			$this->volume = -1;
		
	}
	public function getVolume() {
		return $this->volume;
	}
	
	public function setFlood($floodLevel) {
		$this->floodLevel = $this->tri($floodLevel);
	}
	public function getFlood() {
		return $this->floodLevel;
	}
	
	private function tri($string) {
		return trim($string, chr(0xC2).chr(0xA0)); //unicode zlo &nbsp; -> C2A0
	}
	
	
 }

 ?>
