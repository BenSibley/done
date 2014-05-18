<?php
/* require this file */
$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $absolute_path[0] . 'wp-load.php';
require_once($wp_load);

/* allow caching */
$expires = 60*60*24; // how long to cache in secs..
header("Pragma: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
/* change type to stylesheet*/
header('Content-type: text/css');
