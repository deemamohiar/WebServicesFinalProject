<?php
    // This line is so that the JWT class is recognized
    include("C:\\xampp\\htdocs\\WebServicesFinalProject\\vendor\\autoload.php");

    use Ahc\Jwt\JWT;

    class AuthController {
        function authenticateClient($payload) {
            // Step 1: check if API key / license number are valid
            $decodedBody = (array) json_decode($payload);
            $APIKey = $decodedBody['APIKey'];
            $licenseNumber = $decodedBody['licenseNumber'];
            $licenseEndDate = $decodedBody['licenseEndDate'];

            echo $licenseEndDate;
            $licenseEndDate = strtotime(date('Y-m-d H:i:s', strtotime($licenseEndDate)));
            $currentDate = strtotime(date('Y-m-d H:i:s'));

            if ($APIKey != "countrySearchKey" || $licenseNumber == "" || $currentDate > $licenseEndDate) {
                // Stop from going further
                return;
            }
            
            // Step 2: if everything is valid, create token
            $jwt = new JWT('secretKey', 'HS256', 3600, 10);

            $payload = ['webService' => 'L&D Country Search',
                        'clientLicenseNumber' => $licenseNumber,
                        'expDate' => $licenseEndDate];
            $token = $jwt->encode($payload);

            header("WWW-Authenticate: Bearer $token");
            return $token;
        }

        public function debug_to_console($data) {
            $output = $data;
            if (is_array($output))
                $output = implode(',', $output);
        
            echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
        }
    }
?>