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

        // for ($i = 0; $i < strlen($response); $i++) {
        //     if ($response[$i] == "{") {
        //         echo "<br>";
        //     }
        //     if ($response[$i] == "},") {
        //         echo "\n\r";
        //     }
        //     echo $response[$i];
        // }

        // echo $response;
        $responseArr = (array) json_decode($response,true);
        // print_r($responseArr);

        // If there all multiple countries returned
        if (!isset($responseArr['name'])) {
            $this->printAllData($responseArr);
        }
        // If there's only one country returned
        else {
            $this->printCountryData($responseArr);
        }

        curl_close($curl);  
        
        $now = new DateTime();
        $newSearch->searchCompletionDate = $now->format('Y-m-d H:i:s');

        // only store the user input if anything was inputted (dont if get all countries was selected)
        if($input != null) {
            $newSearch->userInput = $input;
        }
        else {
            $newSearch->userInput = "";
        }

        $newSearch->searchResult = $response;
        $newSearch->insert();

    }

    /*
    If response contains multiple countries, use this formatting
    */
    public function printAllData($responseArr) {
        // Separate the countries from each other
        foreach($responseArr as $country) {
            $countryNames = $country['name'];
            $officialCountryName = $countryNames['official'];

            // Set header for the country
            echo "<p style='text-align:center; font-size:22px; color:blue;'>====================$officialCountryName====================</p>";
            
            // Go through each names for the country
            echo "<p style='font-size:20px;'><b><u>Names:</u></b></p>";
    
            foreach($countryNames as $countryName) {
                if (!is_array($countryName)) {
                    echo $countryName;
                    echo "<br>";
                }
                else {
                    echo "<br>";
                    echo "<p style='font-size:20px;'><b><u>Native Names</b> <i>(name in native languages):</u></i></p>";

                    foreach($countryName as $nativeNames) {
                        foreach($nativeNames as $nativeName) {
                            echo $nativeName;
                            echo "<br>";
                        } 
                    }
                }   
            }

            // Get the country codes for the country
            echo "<p style='font-size:20px;'><b><u>Country Codes:</u></b></p>";
            if (isset($country['cca2'])) {
                echo "CCA2 Code: " . $country['cca2']; 
                echo "<br>";
            }
            if (isset($country['ccn3'])) {
                echo "CCN3 Code: " . $country['ccn3']; 
                echo "<br>";
            }
            if (isset($country['cca3'])) {
                echo "CCA3 Code: " . $country['cca3'];
                echo "<br>"; 
            }
            if (isset($country['cioc'])) {
                echo "CIOC Code: " . $country['cioc']; 
            }
            if (!isset($country['cca2']) && 
                !isset($country['ccn3']) &&
                !isset($country['cca3']) &&
                !isset($country['cioc'])) {
                echo "---";
            }

            // Go through each of the currencies for the country
            echo "<br>";
            echo "<p style='font-size:20px;'><b><u>Currency:</u></b></p>";

            if (isset($country['currencies'])) {
                $currencies = $country['currencies'];
                foreach($currencies as $currency) {
                    echo "Abbreviation: " . key($currencies);
                    echo "<br>";
                    echo "Name: " . $currency['name'];
                    echo "<br>";
                    if (isset($currency['symbol'])) {
                        echo "Symbol: " . $currency['symbol'];
                    }
                    else {
                        echo "Symbol: N.A.";
                    }
                }
            }
            else {
                echo "---";
            }
            
            // Go through each of the languages for the country
            echo "<br>";
            echo "<p style='font-size:20px;'><b><u>Languages:</u></b></p>";

            if (isset($country['languages'])) {
                $languages = $country['languages'];
                foreach($languages as $language) {
                    echo $language;
                    echo "<br>";
                }
            }
            else {
                echo "---";
            }

            // Get the capital city for the country
            echo "<p style='font-size:20px;'><b><u>Capital City:</u></b></p>";

            if (isset($country['capital'])) {
                $capital = $country['capital'];
                echo array_values($capital)[0];
            }
            else {
                echo "---";
            }

            // Get the region for the country
            echo "<br>";
            echo "<p style='font-size:20px;'><b><u>Region:</u></b></p>";
            echo $country['region'];

            // Get the subregion for the country 
            echo "<br>";
            echo "<p style='font-size:20px;'><b><u>Subregion:</u></b></p>";
            if (isset($country['subregion'])) {
                echo $country['subregion'];
            }
            else {
                echo "---";
            }

            // Get the demonym for that country
            echo "<br>";
            echo "<p style='font-size:20px;'><b><u>Demonym:</u></b></p>";
            if (isset($country['demonyms'])) {
                $allDemonyms = $country['demonyms'];
                
                $langCounter = 0;
                $genderCounter = 0;
                foreach($allDemonyms as $demonyms) {
                    // Separate based on languages (eng (0) / fr (1))
                    if ($langCounter == 0) {
                        echo "<u>In English:</u>";
                        echo "<br>";
                        // Separate based on gender (f (0) / m (1))
                        foreach($demonyms as $demonymGender) {
                            if ($genderCounter == 0) {
                                echo "Woman: " . $demonymGender;
                                $genderCounter++;
                                echo "<br>";
                            }
                            else {
                                echo "Man: " . $demonymGender;
                                echo "<br>";
                                $genderCounter = 0;
                            }
                        }

                        $langCounter++;
                    }
                    else {
                        echo "<br>";
                        echo "<u>In French:</u>";
                        echo "<br>";

                        // Separate based on gender (f (0) / m (1))
                        foreach($demonyms as $demonymGender) {
                            if ($genderCounter == 0) {
                                echo "Femme: " . $demonymGender;
                                $genderCounter++;
                                echo "<br>";
                            }
                            else {
                                echo "Homme: " . $demonymGender;
                            }
                        }
                    }
                }
            }
            else {
                echo "---";
            }
        }
    }

    /*
    If response contains only one country, use this formatting
    */
    public function printCountryData($responseArr) {
        $countryNames = $responseArr['name'];
        $officialCountryName = $countryNames['official'];

        // Set header for the country
        echo "<p style='text-align:center; font-size:22px; color:blue;'>====================$officialCountryName====================</p>";
        
        // Go through each names for the country
        echo "<p style='font-size:20px;'><b><u>Name:</u></b></p>";

        foreach($countryNames as $countryName) {
            if (!is_array($countryName)) {
                echo $countryName;
                echo "<br>";
            }
            else {
                echo "<br>";
                echo "<p style='font-size:20px;'><b><u>Native Name</b> <i>(name in native languages):</u></i></p>";

                foreach($countryName as $nativeNames) {
                    foreach($nativeNames as $nativeName) {
                        echo $nativeName;
                        echo "<br>";
                    } 
                }
            }   
        }

        // Get the country codes for the country
        echo "<p style='font-size:20px;'><b><u>Country Codes:</u></b></p>";
        if (isset($responseArr['cca2'])) {
            echo "CCA2 Code: " . $responseArr['cca2']; 
            echo "<br>";
        }
        if (isset($responseArr['ccn3'])) {
            echo "CCN3 Code: " . $responseArr['ccn3']; 
            echo "<br>";
        }
        if (isset($responseArr['cca3'])) {
            echo "CCA3 Code: " . $responseArr['cca3'];
            echo "<br>"; 
        }
        if (isset($responseArr['cioc'])) {
            echo "CIOC Code: " . $responseArr['cioc']; 
        }
        if (!isset($responseArr['cca2']) && 
            !isset($responseArr['ccn3']) &&
            !isset($responseArr['cca3']) &&
            !isset($responseArr['cioc'])) {
            echo "---";
        }

        // Go through each of the currencies for the country
        echo "<p style='font-size:20px;'><b><u>Currency:</u></b></p>";

        if (isset($responseArr['currencies'])) {
            $currencies = $responseArr['currencies'];
            foreach($currencies as $currency) {
                echo "Abbreviation: " . key($currencies);
                echo "<br>";
                echo "Name: " . $currency['name'];
                echo "<br>";
                if (isset($currency['symbol'])) {
                    echo "Symbol: " . $currency['symbol'];
                }
                else {
                    echo "Symbol: N.A.";
                }
            }
        }
        else {
            echo "---";
        }
        
        // Go through each of the languages for the country
        echo "<br>";
        echo "<p style='font-size:20px;'><b><u>Languages:</u></b></p>";

        if (isset($responseArr['languages'])) {
            $languages = $responseArr['languages'];
            foreach($languages as $language) {
                echo $language;
                echo "<br>";
            }
        }
        else {
            echo "---";
        }

        // Get the capital city for the country
        echo "<p style='font-size:20px;'><b><u>Capital City:</u></b></p>";

        if (isset($responseArr['capital'])) {
            $capital = $responseArr['capital'];
            echo array_values($capital)[0];
        }
        else {
            echo "---";
        }

        // Get the region for the country
        echo "<br>";
        echo "<p style='font-size:20px;'><b><u>Region:</u></b></p>";
        echo $responseArr['region'];

        // Get the subregion for the country 
        echo "<br>";
        echo "<p style='font-size:20px;'><b><u>Subregion:</u></b></p>";
        if (isset($responseArr['subregion'])) {
            echo $responseArr['subregion'];
        }
        else {
            echo "---";
        }

        // Get the demonym for that country
        echo "<br>";
        echo "<p style='font-size:20px;'><b><u>Demonym:</u></b></p>";
        if (isset($responseArr['demonyms'])) {
            $allDemonyms = $responseArr['demonyms'];
            
            $langCounter = 0;
            $genderCounter = 0;
            foreach($allDemonyms as $demonyms) {
                // Separate based on languages (eng (0) / fr (1))
                if ($langCounter == 0) {
                    echo "<u>In English:</u>";
                    echo "<br>";
                    // Separate based on gender (f (0) / m (1))
                    foreach($demonyms as $demonymGender) {
                        if ($genderCounter == 0) {
                            echo "Woman: " . $demonymGender;
                            $genderCounter++;
                            echo "<br>";
                        }
                        else {
                            echo "Man: " . $demonymGender;
                            echo "<br>";
                            $genderCounter = 0;
                        }
                    }

                    $langCounter++;
                }
                else {
                    echo "<br>";
                    echo "<u>In French:</u>";
                    echo "<br>";

                    // Separate based on gender (f (0) / m (1))
                    foreach($demonyms as $demonymGender) {
                        if ($genderCounter == 0) {
                            echo "Femme: " . $demonymGender;
                            $genderCounter++;
                            echo "<br>";
                        }
                        else {
                            echo "Homme: " . $demonymGender;
                        }
                    }
                }
            }
        }
        else {
            echo "---";
        }
    }
}