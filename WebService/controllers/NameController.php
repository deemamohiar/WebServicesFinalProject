<?php

// This line is so that the JWT class is recognized
include("C:\\xampp\\htdocs\\WebServicesFinalProject\\vendor\\autoload.php");

use Ahc\Jwt\JWT;

class NameController {
    public function index($userInput) {
        
        $url = "https://restcountries.com/v3.1/name/$userInput";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);

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