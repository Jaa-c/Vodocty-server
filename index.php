<?php
/**
 * vodocty, Android app
 *
 * @package   vodocty.web
 * @author     Daniel Princ, dan@princ.name
 * @version    0.1
 *
 */
ini_set("display_errors", 1);
ini_set("html_errors", 0);

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
//error_reporting(0);
header('Content-type: text/plain; charset=utf-8');

define('JAA', true);
define('DATA_FOLDER', 'data/');
define('MAX_TIME', 2*7*24*60*60);


if($_GET['cron'] != 13) {
	exit;
}

/** vlozeni funkci pouzivanych vsude mozne */
require_once "inc.php";
//vygenerovat ID souboru
$allFeeds = Feeds::getFeeds();

//pole rek [reka] => pole limigrafu
foreach($allFeeds as $state => $feeds) {
	$path = DATA_FOLDER . $state . '/';
	$rivers = array();
	
	$loader = new Loader($feeds);
	$loader->load($rivers);
	
	//echo "zpracovan rek: " . sizeof($rivers) . "\n";
	ksort($rivers);
	
	$prev = file_get_contents($path . 'rivers');
	$prevRivers = unserialize($prev);
	
	$curr = serialize($rivers);
	file_put_contents($path . 'rivers', $curr);
	
	$xml = new XMLExport($rivers, $prevRivers);
	$time = time();
	$created= $xml->save($state, $time); //ulozit zaznam s danym ID
	
	if($created) {
		LogHandler::handle($state, $time);
	}
}

?>
