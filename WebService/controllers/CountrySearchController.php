<?php

require("C:\\xampp\\htdocs\\WebServicesFinalProject\\WebService\\core\\Controller.php");
require("C:\\xampp\\htdocs\\WebServicesFinalProject\\WebService\\models\\CountrySearchModel.php");

/* 
This controller takes care of the web server-side methods.
It includes an index function where authentication is verified, as well as a
getCountry function to match the client's request
*/ 
class CountrySearchController {

    /*
    This function is to verify authentication
    Input can be null for the case of all controller
    */
    public function index($clientID, $input = null) {
        // Start by checking if token exists
        $requestHeaders = apache_request_headers();
        if (!isset($requestHeaders['Authorization'])) {
            $errorMessage = "WWW-Authenticate: Bearer realm=\"api/auth\", 
                            error=\"Access Denied\", 
                            error_description=\"Invalid access token: null\"";
            echo "HTTP/1.1 401 Unauthorized";
            echo "<br>";
            echo $errorMessage;
            return;
        }
        
        // if authentication has been completed successfully, move on to searching for country 
        // check if input has been sent from the client side and pass as a parameter accordingly
        if($input != null) {
            $this->getCountry($clientID, $input);
        }
        else {
            $this->getCountry($clientID);
        }
            
    }

    /*
    This function is to get country information based on the client's request
    */
    public function getCountry( $clientID, $input = null) {
        // If it does, proceed
        $category = $_SESSION['category'];

        // if there are spaces in user input, remove them so it can be passed in URL
        $input = str_replace(' ', '%20', $input);

        $url = "";

        switch ($category) {
            case 'all':
                $url = 'https://restcountries.com/v3.1/all';
                break;
            case 'code':
                $url = "https://restcountries.com/v3.1/alpha/$input";
                break;
            case 'listCodes':
                $url = "https://restcountries.com/v3.1/alpha?codes=$input";
                break;
            case 'capital':
                $url = "https://restcountries.com/v3.1/capital/$input";
                break;
            case 'currency':
                $url = "https://restcountries.com/v3.1/currency/$input";
                break;
            case 'lang':
                $url = "https://restcountries.com/v3.1/lang/$input";
                break;
            case 'name':
                $url = "https://restcountries.com/v3.1/name/$input";
                break;
            case 'fullname':
                $url = "https://restcountries.com/v3.1/lang/$input?fullText=true";
                break;
            case 'region':
                $url = "https://restcountries.com/v3.1/region/$input";
                break;
            case 'subregion':
                $url = "https://restcountries.com/v3.1/subregion/$input";
                break;
            case 'demonym':
                $url = "https://restcountries.com/v3.1/demonym/$input";
                break;
        }

        $newSearch = new \WebServicesFinalProject\WebService\models\CountrySearchModel();
        $newSearch->clientID = $clientID;
        $now = new DateTime();
        $newSearch->searchDate = $now->format('Y-m-d H:i:s');

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);

        $errorMessage = '{"status":';

        // display error message if nothing was found
        if(str_starts_with($response, $errorMessage)) {
            echo "<h1 style='color:red; text-align:center;'>No results found.</h1>";
            echo "<h2 style='color:red; text-align:center;'>Please try again with a different input.</h2>";
            echo "<a style='padding-left:47%; font-size: 25px;' href='/WebServicesFinalProject/Client/ClientController/index'>Search again</a>";
            return;
        }

        // if data was retrieved, display it
        echo "<a style= 'text-decoration: none;' 'color: black;' 'text-shadow: 0px 0px 3px #a8d8ff;' 'font-family: Verdana;' 'font-size: 18px;' href='/WebServicesFinalProject/Client/ClientController/index'>Back to Home Page</a>";
        echo "<br><br>";

        for ($i = 0; $i < strlen($response); $i++) {
            if ($response[$i] == "{") {
                echo "<br>";
            }
            if ($response[$i] == "},") {
                echo "\n\r";
            }
            echo $response[$i];
        }

        curl_close($curl);  
        
        $now = new DateTime();
        $newSearch->searchCompletionDate = $now->format('Y-m-d H:i:s');

        // only store the user input if anything was inputted (dont if get all countries was selected)
        if($input != null) {
            $newSearch->userInput = $input;
        }

        $newSearch->searchResult = $response;

        $newSearch->insert();

    }
}