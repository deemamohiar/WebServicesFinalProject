<?php 

namespace WSFinalProj\models;

class ClientModel extends \WSFinalProj\core\ConnectionManager {

    public $clientName;
    public $email;
    public $password;
    public $password_hash;
    public $licenseNumber;
    public $licenseStartDate;
    public $licenseEndDate;
    public $APIKey;

    public function __construct() {
        parent::__construct();
    }

    public function insert() {
        $this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        $SQL = "INSERT INTO client ( 
                clientName, email, password_hash, licenseNumber, licenseStartDate, licenseEndDate, APIKey) 
                VALUES (:clientName, :email, :password_hash, :licenseNumber, :licenseStartDate, :licenseEndDate 
                :APIKey)";
        $statement = self::$_connection->prepare($SQL);
        $statement->execute(['clientName' => $this->clientName,
                    'email' => $this->email,
                    'password_hash' => $this->password_hash,
                    'licenseNumber' => $this->licenseNumber,
                    'licenseStartDate'=> $this->licenseStartDate,
                    'licenseEndDate' => $this->licenseEndDate,
                    'APIKey' => $this->APIKey]);
    }

    // get client with matching email
    public function getByEmail($email) {
        $SQL = "SELECT * FROM client WHERE email = :email";
        $statement = self::$_connection->prepare($SQL);
        $statement->execute(['email'=>$email]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'WSFinalProject\\client\\models\\ClientModel');
		return $statement->fetch();
    }
}