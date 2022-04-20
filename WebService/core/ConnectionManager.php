<?php

namespace Assignment3\webservice\core;

class ConnectionManager {
        protected static $_connection = null;
        private $host;
        private $user;
        private $password;
        private $dbname;

        function __construct() {

            $config = simplexml_load_file(dirname(__DIR__) . '/core/config.xml');

            $this->host = $config->host;
            $this->user = $config->user;
            $this->password = $config->password;
            $this->dbname = $config->dbname;
            $this->getConnection();
        }

        function getConnection() {
            try {
                self::$_connection = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->password);
            }
            catch(\PDOException $exception) {
                echo "Database connection error: " . $exception->getMessage();
            }
            return self::$_connection;
        }
} 