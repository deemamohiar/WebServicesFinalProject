<?php
namespace WebServicesFinalProject\Client\core;

class Controller {
	protected function view($viewName, $data=null) {
		include('views/'. $viewName . '.php');
	}
}