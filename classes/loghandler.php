<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * exportujeme :)
 * 
 * @package vodocty.web 
 */
class LogHandler  {

	private $time;
	
	function __construct($time) {
		$this->time = $time;
	}

	/**
	 * Manages list of last files
	 */
	public function handle() {
		
		$text = file_get_contents(DATA_FOLDER . 'last');
		
		//add new entry to the begining of file
		$out = $this->time . ' ';
		
		$files = explode(' ', $text);
		$limit = $this->time - MAX_TIME;
		$last = 0;
		
		//delete old files
		$reverse = array_reverse($files);
		foreach($reverse as $file) {
			if(trim($file) == "") {
				continue;
			}
			
			if($file < $limit) {
				unlink(DATA_FOLDER . $file. '.xml.gz');
				echo "\n- deleted:" . DATA_FOLDER . $file. '.xml.gz';
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
		file_put_contents(DATA_FOLDER . 'last', $out);
	}

}
