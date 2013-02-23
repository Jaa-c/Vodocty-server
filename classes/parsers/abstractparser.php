<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Parsujeme :)
 * 
 * @package vodocty.web.parsers
 */
abstract class AbstractParser  {
	protected $html;
	protected $data;
	protected $encoding;
	
	protected static $zlo = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>';
	
	public function __construct($url, $encoding) {
		$this->data = array();
		$this->encoding = $encoding;
		$this->get($url);
		$this->parseData();
	}
	
	public function getData() {
		return $this->data;
	}
	
	private function get($url) {
		$string = file_get_contents($url);
		if($this->encoding != 'utf-8') {
			$string = iconv($this->encoding, 'utf-8', $string);
			$string = preg_replace("/charset=$this->encoding/","charset=utf-8", $string);
			//self::$zlo = preg_replace("/charset=$this->encoding/","charset=utf-8", self::$zlo);
		}
		$this->html = $string;                       
	}
	
	protected abstract function parseData();
 }

 ?>
