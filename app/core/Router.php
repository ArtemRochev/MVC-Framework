<?php

class Router {
	const DEFAULT_MODEL = 'Main';
	const DEFAULT_CONTROLLER = 'Main';
	const DEFAULT_ACTION = 'actionIndex';


	function parseRoute() {
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

		return Router::DEFAULT_CONTROLLER;
	}

	function getActionName($routesData) {
		if ( isset($routesData['a']) ) {
			$action = ucfirst($routesData['a']);
			$valueLen = strlen($action);

			for ( $i = 0; $i < $valueLen; $i++ ) {
				if ( $action[$i] == '-' && $i < $valueLen - 1 ) {
					$action[$i+1] = ucfirst($action[$i+1]);
				}
			}

			return 'action' . str_replace('-', '', $action);
		}

		return Router::DEFAULT_ACTION;
	}

	function includeController($name) {
		$controllerPath = PROJ_PATH . 'app/controllers/' . $name . PHP_EXT;

		if ( !file_exists($controllerPath) ) {
			throw new NotFoundException;
		}

		include($controllerPath);
	}

	function includeModel($name) {
		$modelPath = 'app/models/' . $name . PHP_EXT;

		if ( file_exists($modelPath) ) {
			include($modelPath);
		}
	}

	function redirectTo404($msg) {
		die('not found');

		header("HTTP/1.0 404 Not Found");
		header('Location: 404');
	}

	function startRouting() {
		$modelName;
		$controllerName;
		$actionName;
		$model;
		$controller;
		$routesData = $this->parseRoute();

		$controllerName = $this->getControllerName($routesData['routes']);
		$actionName = $this->getActionName($routesData['params']);
		$modelName = $controllerName;

		$modelName = 'Model' . $controllerName;
		$controllerName = 'Controller' . $controllerName;

//		echo "Controller: $controllerName <br>";
//		echo "Action: $actionName <br>";
//		echo "Model: $modelName <br>";

		//die();

		$this->includeController($controllerName);
		$this->includeModel($modelName);
		
		$controler = new $controllerName();
		
		if ( method_exists($controler, $actionName) ) {
			$controler->$actionName();
		} else {
			echo "<h2>404</h2>";
			echo "Controller: $controllerName <br>";
		 	echo "Action: $actionName <br>";
			echo "Model: $modelName <br>";
			die();
			//throw new NotFoundException("404");
		}
	}
}
