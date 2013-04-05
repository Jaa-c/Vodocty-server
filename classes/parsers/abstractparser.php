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
		$options = array(
			'http'=>array(
				'method'=>"GET",
				'header'=> 
					"Accept-language: en-us;q=0.7,en;q=0.3\r\n" .
					"Connection: keep-alive\r\n",
				'user_agent' => "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2;WOW64; Trident/6.0)\r\n",
			)
		);
		
		$context = stream_context_create($options);
		
		$string = file_get_contents($url, false, $context);
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
