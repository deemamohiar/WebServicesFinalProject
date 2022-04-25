<?php
namespace WebServicesFinalProject\webservice\core;

/*
This class is used to load the different views.
*/
class Controller {
	protected function view($viewName, $data=null) {
		include('Assignment3/client/views/'. $viewName . '.php');
	}
}