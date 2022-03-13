<?php
namespace Client\core;

class Controller {
	protected function view($viewName, $data=null) {
		include('Client/views/'. $viewName . '.php');
	}
}