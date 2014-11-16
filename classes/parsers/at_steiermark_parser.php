<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * Parsujeme :)
 * 
 * @package vodocty.web.parsers
 */
class At_steiermark_parser extends AbstractParser {
		
	protected function parseData() {
		$madness = explode('QStation', $this->html[0]); //0 = volume
		$madheight = explode('WStation', $this->html[1]); //1 = height
				

		foreach ($madness as $i => $line) {
			if($i < 2) continue;
			
			$limnigraf = new Limnigraf();
			
			$data = explode(';', $line);
						
			$tmp = explode(" ", $data[0]);
			list($lg, $river) = explode("/", $tmp[1]);
			
			$limnigraf->setRiver(substr($river, 0, -1));
			$limnigraf->setName($lg);
						
			list($t, $vol) = explode("=", $data[18]);
			if($vol <= 0) continue;
			$limnigraf->setVolume($vol);	
			
			$dh = explode(';', $madheight[$i]);
			list($t, $height) = explode("=", $dh[18]);
			$limnigraf->setHeight($height);
			
			$tmp = explode('"', $data[17]);
			$limnigraf->setDate(strtotime($tmp[1]));		
			
			$this->data[] = $limnigraf;
		}
	}
 }

 ?>
