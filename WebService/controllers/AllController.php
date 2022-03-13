<?php

class AllController {
    public function index() {       
        $url = 'https://restcountries.com/v3.1/all';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);
        echo $response;
        
        curl_close($curl);
    }
}