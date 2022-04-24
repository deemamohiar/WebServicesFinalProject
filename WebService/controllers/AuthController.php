<?php
    // This line is so that the JWT class is recognized
    require_once($_SERVER['DOCUMENT_ROOT']. "\\vendor\autoload.php");

    use Ahc\Jwt\JWT;

    class AuthController {
        function authenticateClient() {
            $requestBody = file_get_contents('php://input');

            // Step 1: check if APIkey is valid
            $decodedBody = (array) json_decode($requestBody);
            $APIKey = $decodedBody['apiKey'];

            if ($APIKey != "apiKey123") {
                echo "You are not authorized to make this request.";
                return;
            }
            
            // Step 2: if valid, create token
            // key, algorithm, max age, leeway
            $jwt = new JWT('secretKey', 'HS256', 3600, 10);

            // Can use this for testing purposes (make token expired)
            // $jwt->setTestTimestamp(time() - 10000);

            $payload = ['webServer' => 'TekCompany',
                        'use' => 'videoConversion',
                        'expDate' => '2022-12-31'];
            $token = $jwt->encode($payload);

            header("WWW-Authenticate: Bearer $token");
            return $token;
        }
    }
?>