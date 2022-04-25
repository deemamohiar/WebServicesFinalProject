<?php
namespace WebServicesFinalProject\Client\core;

/*
This class is used to load the different views.
*/
class Controller {
	/*
	Load a specific view from the views folder 
	*/
	protected function view($viewName, $data=null) {
		include('views/'. $viewName . '.php');
	}
}