<?php

namespace Assignment\webservice\core; 

class App { 
	private $controller = 'Assignment3\webservice\controllers\CompanyController';
	private $method = 'index';
	private $params = [];

	public function __construct() {
		$url = $this->parseURL();

		if (isset($url[0])) {
			if (file_exists('Assignment3/webservice/controllers/' . $url[0] . '.php')) {
				$this->controller = '\\Assignment3\\webservice\\controllers\\' . $url[0];
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

		
		// apply access filtering
		// get the attributes
		$reflection = new \ReflectionObject($this->controller); // lets you get data, variable names from other classes
		$controllerAttributes = $reflection->getAttributes();
		$methodAttributes = $reflection->getMethod($this->method)->getAttributes();

		// merge attributes
		$filters = array_values(array_filter(array_merge($controllerAttributes, $methodAttributes)));
		// invoke the filter methods
		foreach($filters as $filter) {
			$filter = $filter->newInstance();
			if($filter->execute()) {
				return; // stop execution before the call_usr_func_array method runs 
			}
		}

		call_user_func_array(array($this->controller, $this->method), $this->params);
	}

	public function parseURL() {
		if(isset($_GET['url'])) {
			return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
}