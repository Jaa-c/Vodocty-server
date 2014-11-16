<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * exportujeme :)
 * 
 * @package vodocty.web 
 */
class SMSExport  {
	
	const RIVER = 'river';
	const LG = 'lg';
	const DATE = 'date';
	const HEIGHT = 'height';
	const VOLUME = 'volume';
	const FLOOD = 'flood';
	const NAME = 'name';
	
	
	private $result;
	private $export = array(
	  "Isel" => array("Lienz", "Hinterbichl"),
	  "MÃ¶ll" => array("Winklern"),
	  "Gail" => array("Mauthen", "Maria Luggau (Moos)"),
	  "Schwarzach" => array("Hopfgarten in Defereggen-Zwenewald"),
	  "Tauernbach" => array("Prossegg"),
	  "Kalserbach" => array("Staniska"),
	  "Lieser" => array("Spittal"),
	  "Lammer" => array("Obergaeu"), 
	  "Saalach" =>array("WeiÃÂbach"),
	  
	);
	
	function __construct($rivers) {
		$this->result = "";
		
		foreach($this->export as $river => $lgnames) {
		  foreach($lgnames as $i => $name) {
		    $lg = $rivers[$river][$name];
		    $r = $river;
		    if($lg != NULL) {
		      switch($river) {
			case "MÃ¶ll": $r = "Moll";break;
			case "Schwarzach": $r = "Defe";break;
		      }
		      if($i == 0)  $this->result .= $r;
		      $this->result .= '/' . substr($lg->getName(), 0, 1) . ' ' 
					      . round($lg->getHeight(), 1) . ' ' . round($lg->getVolume(), 1) . '@' . date('Gi', $lg->getDate()) ."\n"; //'d.n G:i'
		    }
		  }
		}
		echo $this->result;
		echo strlen($this->result) . " znaků\n";
	}
	
	
	public function save($file) {
		if(strlen($this->result) < 5) {
			echo $file . ": no data\n";
			return false;
		}
		
		$name = DATA_FOLDER .$file . '.txt';
		if(file_put_contents($name, $this->result)) {//compress.zlib://
			echo 'created: ' . $name . "\n";                                           
		}
		else {
			echo 'failed creating: ' . $name . "\n";
		}
		return true;
	}
 }

 ?>
