<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
$domain = strpos($_SERVER['HTTP_HOST'], "local") !== FALSE ? "http://local.static/" : "http://static.timesfreepress.com/";
session_start();
function autoloadClass($class){
    spl_autoload(strtolower($class));
}
$realpath = realpath($_SERVER["DOCUMENT_ROOT"]);
set_include_path($realpath."/dotabet/models/db" . PATH_SEPARATOR . $realpath."/dotabet/models/custom");
spl_autoload_extensions('.class.php,.php');
spl_autoload_register('autoloadClass');