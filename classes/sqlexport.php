<?php
if(!defined('JAA')){header("Location: /");exit;}

/**
 * exportujeme :)
 * 
 * @package vodocty.web 
 */
class SQLExport  {
	
	const RIVER = 'river';
	const LG = 'lg';
	const DATE = 'date';
	const HEIGHT = 'height';
	const VOLUME = 'volume';
	const FLOOD = 'flood';
	const NAME = 'name';
	
	private $rivers;
	
	private $db;
	
	function __construct($rivers) {
		$this->rivers = $rivers;
		$dbs = new DB();
		$this->db = $dbs->getDB();
	}
		
	
	public function save($state) {
		if($this->db != NULL)  {
			$query = "INSERT IGNORE INTO `river` VALUES ";
			$qPart = array_fill(0, count($this->rivers), " (NULL, ?, ?)");
			$query .=  implode(",", $qPart);
			$riverST = $this->db->prepare($query);
			
			$lgcount = array_sum(array_map('count', $this->rivers));
			
			$query = "INSERT IGNORE INTO `lg` VALUES ";
			$qPart = array_fill(0, $lgcount, "(NULL, ?, (SELECT id from `river` WHERE name=? AND country=?))");
			$query .=  implode(",", $qPart);
			$lgST = $this->db->prepare($query);
			
			
			$query = "INSERT INTO `data`(id, lg_id, date, height, volume, flood) VALUES ";
			$qPart = array_fill(0, $lgcount, "(NULL, (SELECT id from `lg` WHERE name=? AND river_id= (SELECT id FROM `river` WHERE name=? AND country=?)), ?, ?, ?, ?) ");
			$query .=  implode(",", $qPart);
			$query .= " ON DUPLICATE KEY UPDATE height = VALUES(height), volume = VALUES(volume), flood = VALUES(flood)";
			$dataST = $this->db->prepare($query);
			
			$i = 1;
			$j = 1;
			$k = 1;
			foreach($this->rivers as $river => $lgs) {
				$riverST->bindValue($i++, $river, PDO::PARAM_STR);
				$riverST->bindValue($i++, $state);
				
				foreach($lgs as $index => $lg) {
					$lgST->bindValue($j++, $lg->getName());
					$lgST->bindValue($j++, $river);
					$lgST->bindValue($j++, $state);
					
					$dataST->bindValue($k++, $lg->getName());
					$dataST->bindValue($k++, $river);
					$dataST->bindValue($k++, $state);
					if($lg->getDate() == -1) {
						$dataST->bindValue($k++, 'NULL');
					}
					else {
						$dataST->bindValue($k++, date('Y-m-d H:i:s', $lg->getDate()));
					}
					$dataST->bindValue($k++, $lg->getHeight());
					$dataST->bindValue($k++, $lg->getVolume());
					$dataST->bindValue($k++, $lg->getFlood());
				}
			}
			try {
				$riverST->execute();
			} catch(PDOException $ex) {
				echo $ex->getMessage( );
				echo " -> Unable to insert new RIVERS to database\n";
			}
			try {
				$lgST->execute();
			} catch(PDOException $ex) {
				echo $ex->getMessage( );
				echo " -> Unable to insert new LGs to database\n";			
			}
			try {
				$dataST->execute();
			} catch(PDOException $ex) {
				echo $ex->getMessage( );
				echo " -> Unable to insert new DATA to database\n";			
			}
		}
		echo "Saved new data to database - " . $state . "\n";
		$this->db->query("DELETE FROM `data` WHERE date < NOW() - INTERVAL 2 WEEK");
	}
 }

 ?>