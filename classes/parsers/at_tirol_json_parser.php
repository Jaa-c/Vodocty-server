<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Parsujeme :)
 * 
 * @package vodocty.web.parsers
 */
class At_tirol_json_parser extends AbstractParser {
	
	protected function parseData() {
		$data = json_decode($this->html, true);
		
		foreach ($data as $riverObject) {
			$limnigraf = new Limnigraf(); 
			$limnigraf->setRiver($riverObject["WTO_OBJECT"]);
			$limnigraf->setName($riverObject["name"]);
						
			$data = $riverObject["values"]["W"]["15m.Cmd.HD"];
			if($data == NULL) $data = $riverObject["values"]["W"]["15m.Cmd.P"];
			if($data == NULL) {
				foreach($riverObject["values"]["W"] as $key => $d) {
					if("15m.Cmd." == substr($key, 0, 8)) {
						$data = $d;
					}
				}
			}
			if($data == NULL) {continue;}
			$height = $data["v"];
			$d = $data["dt"];
			$limnigraf->setHeight($height);
			
			$data = $riverObject["values"]["Q"]["15m.Cmd.HD"];
			if($data == NULL) $data = $riverObject["values"]["Q"]["15m.Cmd.P"];
			if($data == NULL) {
				foreach($riverObject["values"]["Q"] as $key => $data) {
					if("15m.Cmd." == substr($key, 0, 8)) {
						$data = $d;
					}
				}
			
			}
			$vol = $data['v'];
			if($d == NULL)  $d = $data["dt"];
			$limnigraf->setVolume($vol);
			
			$date = new DateTime(date("c", $d / 1000));
			$limnigraf->setDate(strtotime($date->format('d-m-Y H:i:s')));
			
			$this->data[] = $limnigraf;
		}
	}
 }

 ?>
