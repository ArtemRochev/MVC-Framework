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

		return Router::DEFAULT_ACTION;
	}

	function includeController($name) {
		$controllerPath = PROJ_PATH . 'app/controllers/' . $name . PHP_EXT;

		if ( !file_exists($controllerPath) ) {
			throw new NotFoundException;
		}

		require_once($controllerPath);
	}

	function includeModel($name) {
		$modelPath = 'app/models/' . $name . PHP_EXT;

		if ( file_exists($modelPath) ) {
			include($modelPath);
		}
	}

	function startRouting() {
		$modelName;
		$controllerName;
		$actionName;
		$model;
		$controller;
		$routesData = $this->parseRoute();

		//var_dump($routesData);
		//die();

		$controllerName = $this->getControllerName($routesData['routes']);
		$actionName = $this->getActionName($routesData['routes']);
		$modelName = $controllerName;

		$modelName = 'Model' . $controllerName;
		$controllerName = 'Controller' . $controllerName;

		if ( !empty($_GET['debug']) ) {
			echo "Controller: $controllerName <br>";
			echo "Action: $actionName <br>";
			echo "Model: $modelName <br>";
			//die();
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
}
