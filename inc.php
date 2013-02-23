<?php
/**
 * inc.php
 * 
 * Funkce pouzivane vsude mozne  
 */

if(!defined('JAA')){header("Location: /");exit;}

/** Nacteni souboru k danym tridam */
function __autoload($classname) {
    $filename = strtolower($classname.".php");
    if(strtolower(substr($classname, -6)) == "parser")
    	    include("classes/parsers/".$filename);
    else
    	include("classes/".$filename);
}

?>
