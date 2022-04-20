<?php

namespace Assignment3\webservice\core;

class Model {
	protected static $_connection = null;

	public function __construct() {
		$username = 'root';
		$password = '';
		$host = 'localhost';
		$DBname = 'assignment1';

		if(self::$_connection == null) {
			self::$_connection = new \PDO("mysql:host=$host;dbname=$DBname", $username, $password);
		}
	}
}