<?php

class AllController {
    // input parameter will not be used in this controller, but is needed for every other one
    public function index($input = null) {
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
        $url = 'https://restcountries.com/v3.1/all';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);
        echo "<a style= 'text-decoration: none;' 'color: black;' 'text-shadow: 0px 0px 3px #a8d8ff;' 'font-family: Verdana;' 'font-size: 18px;' href='/WebServicesFinalProject/Client/ClientController/index'>Back to Home Page</a>";
        echo "<br><br>";
        $counter = 0;
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
    }
}