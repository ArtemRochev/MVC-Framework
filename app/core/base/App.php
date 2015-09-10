<?php

require_once(APP_PATH . 'models/User.php');

class App {
	const DEFAULT_MODEL = 		'Main';
	const DEFAULT_CONTROLLER = 	'Main';
	const DEFAULT_ACTION = 		'actionIndex';

	//public static $user;

	private function parseRoute() {
		$data = explode('?', $_SERVER['REQUEST_URI']);

		$routes = explode('/', $data[0]);
		$params = [];

		if ( isset($data[1]) ) {
			$paramPairs = explode('&', $data[1]);

			foreach ( $paramPairs as $param) {
				$explodedParam = explode('=', $param);

				$params[$explodedParam[0]] = $explodedParam[1];
			}
		}

		return array(
			'routes' => $routes,
			'params' => $params
		);
	}

	function getControllerName($routesData) {
		if ( $routesData[1] != '' ) {
			return ucfirst($routesData[1]);
		}

		return App::DEFAULT_CONTROLLER;
	}

	function getActionName($routesData) {
		if ( isset($routesData[2]) ) {
			$action = ucfirst($routesData[2]);
			$valueLen = strlen($action);

			for ( $i = 0; $i < $valueLen; $i++ ) {
				if ( $action[$i] == '-' && $i < $valueLen - 1 ) {
					$action[$i+1] = ucfirst($action[$i+1]);
				}
			}

			return 'action' . str_replace('-', '', $action);
		}

		return App::DEFAULT_ACTION;
	}

	function includeController($name) {
		$controllerPath = APP_PATH . 'controllers/' . $name . PHP_EXT;

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

	public function run() {
		$modelName;
		$controllerName;
		$actionName;
		$model;
		$controller;
		$routesData = $this->parseRoute();

		$controllerName = $this->getControllerName($routesData['routes']);
		$actionName = $this->getActionName($routesData['routes']);
		$modelName = $controllerName;

		$modelName = 'Model' . $controllerName;
		$controllerName = 'Controller' . $controllerName;

		if ( !empty($_GET['debug']) ) {
			echo "Controller: $controllerName <br>";
			echo "Action: $actionName <br>";
			echo "Model: $modelName <br>";
			die();
		}

		$this->includeController($controllerName);
		$this->includeModel($modelName);
		
		$controler = new $controllerName();
		
		if ( method_exists($controler, $actionName) ) {
			$controler->$actionName();
		} else {
			throw new NotFoundException("404");
		}
	}

	public static function isAdmin() {
		if ( isset($_COOKIE['token']) && isset($_COOKIE['user_id']) ) {
			$user = User::findById($_COOKIE['user_id']);

			if ( $_COOKIE['token'] == $user->token && $user->is_admin ) {
				return true;
			}
		}

		return false;
	}
}
