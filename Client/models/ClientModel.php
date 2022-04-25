<?php 

namespace WebServicesFinalProject\Client\models;

require("C:\\xampp\\htdocs\\WebServicesFinalProject\\Client\\core\\ConnectionManager.php");

/*
This class is the model for Clients (so it's used to create and manipulate clients)
*/
class ClientModel extends \core\ConnectionManager {

    public $clientName;
    public $email;
    public $password;
    public $passwordHash;
    public $licenseNumber;
    public $licenseStartDate;
    public $licenseEndDate;
    public $APIKey;

    /*
    Constructor coming from the Connection Manager
    */
    public function __construct() {
        parent::__construct();
    }

    /*
    To insert a new client into the database
    */
    public function insert() {
        $this->passwordHash = password_hash($this->password, PASSWORD_DEFAULT);
        
        $SQL = "INSERT INTO client (clientName, email, passwordHash, 
                licenseNumber, licenseStartDate, licenseEndDate, APIKey) 
                VALUES (:clientName, :email, :passwordHash, :licenseNumber,
                :licenseStartDate, :licenseEndDate, :APIKey)";
        $statement = self::$_connection->prepare($SQL);
        $statement->execute(['clientName' => $this->clientName,
                    'email' => $this->email,
                    'passwordHash' => $this->passwordHash,
                    'licenseNumber' => $this->licenseNumber,
                    'licenseStartDate'=> $this->licenseStartDate,
                    'licenseEndDate' => $this->licenseEndDate,
                    'APIKey' => $this->APIKey]);
    }

    /*
    To retrieve a client by their email
    */
    public function getByEmail($email) {
        $SQL = "SELECT * FROM client WHERE email = :email";
        $statement = self::$_connection->prepare($SQL);
        $statement->execute(['email'=>$email]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 
        'WebServicesFinalProject\\Client\\models\\ClientModel');
        return $statement->fetch();
    }

    /*
    To check if a client already exists based on the email used
    */
    public function emailExists($email) {
        $SQL = "SELECT COUNT(*) AS count FROM client WHERE email = :email";
        $statement = self::$_connection->prepare($SQL);
        $statement->execute(['email'=>$email]);
        return $statement->fetch();
    }

    /*
    To retrieve a client by their ID
    */
    public function getById($clientID) {
        $SQL = "SELECT * FROM client WHERE clientID = :clientID";
        $statement = self::$_connection->prepare($SQL);
        $statement->execute(['clientID'=>$clientID]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 
                            'WebServicesFinalProject\\Client\\models\\ClientModel');
        return $statement->fetch();
    }
}