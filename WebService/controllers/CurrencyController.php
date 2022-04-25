<?php

// This line is so that the JWT class is recognized
include("C:\\xampp\\htdocs\\WebServicesFinalProject\\vendor\\autoload.php");

use Ahc\Jwt\JWT;

class CurrencyController {
    public function index($userInput) {

        // this one gives bad request when u input several words?? 
        $url = "https://restcountries.com/v3.1/currency/$userInput";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);

        $errorMessage = '{"status":404,"message":"Not Found"}';

        // display error message if nothing was found
        if($response == $errorMessage) {
            echo "<h1 style='color:red; text-align:center;'>No results found. Please try again with a different input.</h1>";
            echo "<a style='padding-left:47%; font-size: 25px;' href='/WebServicesFinalProject/Client/ClientController/index'>Search again</a>";
            return;
        }

        for ($i = 0; $i < strlen($response); $i++) {
            if ($response[$i] == "{") {
                echo "<br>";
            }
            if ($response[$i] == "},") {
                echo "\n\r";
            }
            echo $response[$i];
        }
    }
}