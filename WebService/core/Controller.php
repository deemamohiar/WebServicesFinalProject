<?php
namespace Assignment3\webservice\core;

class Controller {
	protected function view($viewName, $data=null) {
		include('Assignment3/client/views/'. $viewName . '.php');
	}
}