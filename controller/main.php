<?php
//error_reporting(0);
session_start();

require_once("../config/site.php");
require_once("../config/database.php");
require_once("../core/function.php");
require_once("../core/db.php");

if (isset($_REQUEST)) foreach ($_REQUEST as $k => $v) $$k = clean($v);
if (isset($_SESSION)) foreach ($_SESSION as $k => $v) $$k = clean($v);


$url  = @$_GET["p"];
$path = SITE_SUBDIR."/controller/main.php";
$uri  = preg_split('[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY);
$urix = isset($uri[2]) ? DIRECTORY_SEPARATOR . $uri[2] : "";
$file = getcwd().DIRECTORY_SEPARATOR.$uri[0].".php";
$method = isset($uri[1])?$uri[1]:'main';
if (file_exists($file)){
	require_once($file);
	$c = new Controller();
	if(method_exists($c, $method))$c->$method();
	
}
?>