<?php 

namespace WebServicesFinalProject\WebService\models;

require("C:\\xampp\\htdocs\\WebServicesFinalProject\\WebService\\core\\ConnectionManager.php");

/*
This class is the model for CountrySearch (so it's used to create and manipulate country searches)
*/
class CountrySearchModel extends \core\ConnectionManager {
    public $clientID;
    public $searchDate;
    public $searchCompletionDate;
    public $userInput;
    public $searchResult;

    /*
    Constructor coming from the Connection Manager
    */
    public function __construct() {
        parent::__construct();
    }

    /*
    To insert a new CountrySearch into the database
    */
    public function insert() {
        $SQL = "INSERT INTO countrySearch (clientID, searchDate, searchCompletionDate, userInput, searchResult)  
        VALUES (:clientID, :searchDate, :searchCompletionDate, :userInput, :searchResult)";

        $statement = self::$_connection->prepare($SQL);
        $statement->execute(['clientID'=>$this->clientID,
                    'searchDate'=>$this->searchDate,
                    'searchCompletionDate'=>$this->searchCompletionDate,
                    'userInput'=>$this->userInput,
                    'searchResult'=>$this->searchResult]);
    }
}