<?php
namespace WSFinalProj\core;

class Controller {
	protected function view($viewName, $data=null) {
		include('WSFinalProj/client/views/'. $viewName . '.php');
	}
}