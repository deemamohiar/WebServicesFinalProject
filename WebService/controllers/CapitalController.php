<?php

class CapitalController {
    public function index($userInput) {
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

        // If it does, proceed
        $url = "https://restcountries.com/v3.1/capital/$userInput";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);

        $errorMessage = '{"status":404,"message":"Not Found"}';

        // display error message if nothing was found
        if($response == $errorMessage) {
            echo "<h1 style='color:red; text-align:center;'>No results found.</h1>";
            echo "<h2 style='color:red; text-align:center;'>Please try again with a different input.</h2>";
            echo "<a style='padding-left:47%; font-size: 25px;' href='/WebServicesFinalProject/Client/ClientController/index'>Search again</a>";
            return;
        }

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
    }
}