<?php

namespace core;

/*
This class is used to initialize the first page of our project.
It is also used to fetch other classes and their methods.
*/
class App {

	private $controller = 'controllers\ClientController';
	private $method = 'login';
	private $params = [];

	/*
	Assign the controller, methods, and parameters based on the URL
	*/
	public function __construct() {

		$url = $this->parseURL();

		if (isset($url[0])) {
			if (file_exists('WebServicesFinalProject/Client/controllers/' . $url[0] . '.php')) {
				$this->controller = '\\WebServicesFinalProject\\Client\\controllers\\' . $url[0];
			}

			unset($url[0]);
		}

		$this->controller = new $this->controller;

		if (isset($url[1])) {
			if (method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
			}
			unset($url[1]);
		}

		$this->params = $url ? array_values($url) : [];

		$reflection = new \ReflectionObject($this->controller);
		$controllerAttributes = $reflection->getAttributes();
		$methodAttributes = $reflection->getMethod($this->method)->getAttributes();
		//merge
		$filters = array_values(array_filter(array_merge($controllerAttributes, $methodAttributes)));
		//invoke the filter methods
		foreach($filters as $filter){
			$filter = $filter->newInstance();
			if($filter->execute())
				return;//stop execution before the call_user_func_array method runs
		}

		call_user_func_array(array($this->controller, $this->method), $this->params);
	}

	/*
	To parse the URL (so we can retrieve its data)
	*/
	public function parseURL() {
		if(isset($_GET['url'])) {
			return explode('/', 
				filter_var(rtrim($_GET['url'], '/'), 
				FILTER_SANITIZE_URL));
		}
	}
}