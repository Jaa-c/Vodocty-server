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
		if(is_array($url)) {
			$this->html = array();
			foreach($url as $u) {
				$this->get($u, true);
			}
		}
		else
			$this->get($url);
		try {
		  $this->parseData();
		} catch (Exception $e) {
		  echo "\n Error while parsing: " . $url . "\n";
		}
	}
	
	public function getData() {
		return $this->data;
	}
	
	private function get($url, $array = false) {
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
			//$string = utf8_encode($string);
			$string = preg_replace("/charset=$this->encoding/","charset=utf-8", $string);
		}
		if($array)
			$this->html[] = $string; 
		else
			$this->html = $string; 
	}
	
	protected abstract function parseData();
 }

 ?>
