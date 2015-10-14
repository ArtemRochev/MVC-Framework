<?php

require_once(APP_PATH . 'models/User.php');
require_once(TOOLS_PATH . 'Text.php');

class App {
	const DEFAULT_MODEL = 		'Main';
	const DEFAULT_CONTROLLER = 	'Main';
	const DEFAULT_ACTION = 		'actionIndex';

	//public static $user;
	public static $config;

	public function __construct($config) {
		self::$config = $config;
	}

	public static function parseRoute() {
		$request = $_SERVER['REQUEST_URI'];
		$data = explode('?', $request);
		$admin = false;

		$routes = explode('/', trim($data[0], '/'));
		$params = [];


		if ( $routes[0] == 'admin' ) {
			array_shift($routes);

//			if ( empty($routes[1]) ) {
//				$routes[1] = $routes[0];
//				$routes[0] = App::DEFAULT_CONTROLLER;
//			}

			$admin = true;
		}

		if ( isset($data[1]) ) {
			$paramPairs = explode('&', $data[1]);

			foreach ( $paramPairs as $param) {
				$explodedParam = explode('=', $param);

				$params[$explodedParam[0]] = $explodedParam[1];
			}
		}

		return [
			'routes' => $routes,
			'params' => $params,
			'admin' => $admin
		];
	}

	function getControllerName($routesData) {
		if ( !empty($routesData[0]) ) {
			return Text::hyphenSeparatedToCamelCase($routesData[0]);
		}

		return App::DEFAULT_CONTROLLER;
	}

	function getActionName($routesData) {
		if ( !empty($routesData[1]) ) {
			return 'action' . Text::hyphenSeparatedToCamelCase($routesData[1]);
		}

		return App::DEFAULT_ACTION;
	}

	function includeController($name, $admin = false) {
		if ( !$admin ) {
			$controllerPath = APP_PATH . 'controllers/'		 . $name . PHP_EXT;
		} else {
			$controllerPath = APP_PATH . 'controllers/admin/' . $name . PHP_EXT;
		}

		if ( !file_exists($controllerPath) ) {
			throw new NotFoundException;
		}

		require_once($controllerPath);
	}

	function includeModel($name) {
		$modelPath = APP_PATH . 'models/' . $name . PHP_EXT;

		if ( file_exists($modelPath) ) {
			include($modelPath);
		}
	}

	public static function isAdmin() {
		if ( isset($_COOKIE['token']) && isset($_COOKIE['user_id']) ) {
			$user = User::findById($_COOKIE['user_id']);
			//var_dump('User: (' . $user->token . ')');
			//var_dump($_COOKIE['token']);
			//var_dump($user->token);

			if ( $_COOKIE['token'] == $user->token && $user->is_admin ) {
				return true;
			}
		}

		return false;
	}

	public function run() {
		$modelName;
		$controllerName;
		$actionName;
		$model;
		$controller;
		$routesData = self::parseRoute();

		$controllerName = $this->getControllerName($routesData['routes']);
		$actionName = $this->getActionName($routesData['routes']);
		$modelName = $controllerName;

		$modelName = 'Model' . $controllerName;
		$controllerName = 'Controller' . $controllerName;

		_debug("Controller: $controllerName");
		_debug("Action: $actionName");
		_debug("Model: $modelName");

		$this->includeController($controllerName, $routesData['admin']);
		$this->includeModel($modelName);
		
		$controler = new $controllerName();
		
		if ( method_exists($controler, $actionName) ) {
			$controler->$actionName();
		} else {
			throw new NotFoundException("404");
		}
	}
}
