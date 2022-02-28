<?php

namespace WSFinalProj\core;

class App {

	private $controller = 'WSFinalProj\controllers\ConversionController';
	private $method = 'index';
	private $param = [];

	public function __construct() {

		$url = $this->parseURL();

		if (isset($url[0])) {
			if (file_exists('WSFinalProj/controllers/' . $url[0] . '.php')) {
				$this->controller = '\\WSFinalProj\\controllers\\' . $url[0];
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

	public function parseURL() {

		if(isset($_GET['url'])) {
			return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
}