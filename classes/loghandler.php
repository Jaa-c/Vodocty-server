<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * exportujeme :)
 * 
 * @package vodocty.web 
 */
class LogHandler  {

	/**
	 * Manages list of last files
	 */
	public static function handle($state, $time) {
		$path = DATA_FOLDER . $state . '/';
		
		$text = file_get_contents($path . 'last.txt');
		
		//add new entry to the begining of file
		$out = $time . ' ';
		
		$files = explode(' ', $text);
		$limit = $time - MAX_TIME;
		$last = 0;
		
		//delete old files
		$reverse = array_reverse($files);
		foreach($reverse as $file) {
			if(trim($file) == "") {
				continue;
			}
			
			if($file < $limit) {
				unlink(DATA_FOLDER . $file. '.xml.gz');
				echo "\n- deleted:" . $path . $file. '.xml.gz';
			}
			else {
				$last = $file;
				break;
			}
		}
		
		foreach($files as $file) {
			$out .= $file . ' ';
			if($file == $last) {
				break;
			}
		}
		file_put_contents($path . 'last.txt', $out);
	}

}
