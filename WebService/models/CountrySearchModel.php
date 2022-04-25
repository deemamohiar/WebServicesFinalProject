<?php 

namespace WebServicesFinalProject\WebService\models;

class CountrySearchModel extends \core\ConnectionManager {
    public $clientID;
    public $searchDate;
    public $searchCompletionDate;
    public $userInput;
    public $searchResult;
    
    public function __construct() {
        parent::__construct();
    }

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