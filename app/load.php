<?php

require_once("config.php");
require_once("core/exceptions.php");

require_once('core/Model.php');
require_once('core/View.php');
require_once('core/Controller.php');
require_once('core/Router.php');
require_once('core/db/DatabaseRecord.php');

define("PHP_EXT", '.php');
define('PROJ_PATH', '/home/artem/server/nginx/www/book/');
define('VIEWS_PATH', PROJ_PATH . 'app/views/');

try {
	$db = new PDO("mysql:dbname=" . $config['db']['name'] . ";host=127.0.0.1", "book", "1111");
	$db->exec("SET CHARACTER SET utf8");
	
	DatabaseRecord::setDatabase($db);
} catch (PDOException $e) {
	echo "PDO error: " . $e->getMessage() . "\n";
}

$router = new Router;

try {
	$router->startRouting();
} catch (NotFoundException $e) {
	$router->redirectTo404();
}
//} catch (Exception $e) {
	//echo "somthing do wrong...\n";
	//echo $e->getMessage();
//}
