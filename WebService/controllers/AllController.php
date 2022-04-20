<?php

class AllController {
    public function index() {
        // $requestPayload = file_get_contents('php://input'); 
        // echo $requestPayload;      
        $url = 'https://restcountries.com/v3.1/all';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);
        // echo $response;
        // var_dump($response);

        $counter = 0;
        for ($i = 0; $i < strlen($response); $i++) {
            if ($response[$i] == "{") {
                echo "<br>";
            }+
            if ($response[$i] == "},") {
                echo "\n\r";
            }
            echo $response[$i];
        }

        curl_close($curl);
    }
}