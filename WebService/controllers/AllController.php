<?php

class AllController {
    public function index() {
        // $requestPayload = file_get_contents('php://input'); 
        // echo $requestPayload;      
        $url = 'https://restcountries.com/v3.1/all';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);
        echo $response;
        
        curl_close($curl);
    }
}