<?php

namespace core;

/*
This class is used to connect to the database.
*/
class ConnectionManager {
	protected static $_connection = null;
	private $host;
	private $user;
	private $password;
	private $dbname;

	/*
	Extract the information from the database configuratin file.
	*/
	public function __construct() {
		$config = simplexml_load_file(dirname(__DIR__).'/database/config.xml');

		$this->host = $config->host;
		$this->user = $config->user;
		$this->password = $config->password;
		$this->dbname = $config->dbname;
		
		$this->getConnection();
	}

	/*
	Provide a connection to the database
	*/
	function getConnection() {
		try {
			self::$_connection = new \PDO("mysql:host=".$this->host.";dbname=".$this->dbname, 
							$this->user, $this->password);
		}
		catch(\PDOException $exception) {
			echo "Database Connection error: " . $exception->getMessage();
		}

		return self::$_connection;
	}
}
