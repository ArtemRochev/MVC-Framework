<?php

define("PHP_EXT", '.php');
define('PROJ_PATH', '/home/artem/server/nginx/www/book/');
define('VIEWS_PATH', PROJ_PATH . 'app/views/');
define('CORE_PATH', PROJ_PATH . 'app/core/');

require_once(PROJ_PATH . 'app/config.php');

require_once(CORE_PATH . 'exceptions.php');
require_once(CORE_PATH . 'base/Model.php');
require_once(CORE_PATH . 'base/View.php');
require_once(CORE_PATH . 'base/Controller.php');
require_once(CORE_PATH . 'base/Router.php');
require_once(CORE_PATH . 'db/DatabaseRecord.php');


try {
	$db = new PDO("mysql:" .
		"dbname=" . $config['db']['name'] .
		";host=" .  $config['db']['host'],
					$config['db']['user'],
					$config['db']['pass']);

	$db->exec("SET NAMES SET" . $config['character']);
	
	DatabaseRecord::setDatabase($db);
} catch (PDOException $e) {
	echo "PDO error: " . $e->getMessage() . "\n";
}

$router = new Router;

try {
	$router->startRouting();
} catch (NotFoundException $e) {
	Controller::redirectTo404();
}
