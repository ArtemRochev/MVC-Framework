<?php

define("PHP_EXT", '.php');
define('APP_PATH', __DIR__ . '/');
define('VIEWS_PATH', APP_PATH . 'views/');
define('CORE_PATH', APP_PATH . 'core/');
define('TOOLS_PATH', CORE_PATH . 'tools/');

require_once(APP_PATH . 'config.php');
require_once(CORE_PATH . 'exceptions.php');
require_once(CORE_PATH . 'systemFunctions.php');
require_once(CORE_PATH . 'base/Model.php');
require_once(CORE_PATH . 'base/View.php');
require_once(CORE_PATH . 'base/Controller.php');
require_once(CORE_PATH . 'base/App.php');
require_once(CORE_PATH . 'db/DatabaseRecord.php');

try {
	$db = new PDO("mysql:" .
		"dbname=" . $config['db']['name'] . ';' .
		"host=" .	$config['db']['host'],
					$config['db']['user'],
					$config['db']['pass']);

	DatabaseRecord::setDatabase($db, $config['character']);
} catch (PDOException $e) {
	echo "PDO error: " . $e->getMessage() . "\n";
}

$app = new App($config);

try {
	$app->run();
} catch (NotFoundException $e) {
	Controller::redirectTo404(explode('?', $_SERVER['REQUEST_URI'])[0]);
}
