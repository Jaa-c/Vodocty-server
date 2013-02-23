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
ini_set("html_errors", 1);

error_reporting(E_ALL ^ E_WARNING);
header('Content-type: text/plain; charset=utf-8');

define('JAA', true);
define('DATA_FOLDER', './data/');
define('MAX_TIME', 2*7*24*60*60);

/** vlozeni funkci pouzivanych vsude mozne */
require_once "inc.php";
//vygenerovat ID souboru
$feeds = Feeds::getFeeds();

//pole rek [reka] => pole limigrafu
$rivers = array();

$loader = new Loader($feeds);
$loader->load($rivers);

//echo "zpracovan rek: " . sizeof($rivers) . "\n";
ksort($rivers);

$prev = file_get_contents(DATA_FOLDER . 'rivers');
$prevRivers = unserialize($prev);

$curr = serialize($rivers);
file_put_contents(DATA_FOLDER . 'rivers', $curr);

$xml = new XMLExport($rivers, $prevRivers);
$time = time();
$created= $xml->save($time); //ulozit zaznam s danym ID

if($created) {
	$log = new LogHandler($time);
	$log->handle();
}

?>
