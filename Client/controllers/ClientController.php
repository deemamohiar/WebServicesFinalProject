<?php
	namespace controllers;
	require("C:\\xampp\\htdocs\\WebServicesFinalProject\\Client\\core\\Controller.php");
	require("C:\\xampp\\htdocs\\WebServicesFinalProject\\Client\\models\\ClientModel.php");

	use DateTime;
	use DatePeriod;
	use DateInterval;

	class ClientController extends \WebServicesFinalProject\Client\core\Controller {

		public function register() {
			if (isset($_POST['registerB'])) {
				// Verify that all fields are filled
				if (empty($_POST['name']) || empty($_POST['email']) ||  
					empty($_POST['password']) || empty($_POST['passwordConfirm'])) {
	
					$errorMessage = "Please fill up all required fields.";
					$this->view('RegisterView', $errorMessage);
					return;
				}
	
				// Verify that passwords correspond
				if ($_POST['password'] != $_POST['passwordConfirm']) {
					$errorMessage = "The inputted passwords do not match.";
					$this->view('RegisterView', $errorMessage);
					return;
				}
		
				$client = new \WebServicesFinalProject\Client\models\ClientModel();
		
				// Verify that account doesn't already exist
				$clientExists = $client->emailExists($_POST['email']);

				if ($clientExists[0] > 0) {
					$errorMessage = "An account already exists with this email.";
					$this->view('RegisterView', $errorMessage);
					return;
				}

				// Otherwise, if all is well, register client
				$client->clientName = $_POST['name'];
				$client->email = $_POST['email'];
				$client->password = $_POST['password'];
				// This is temporary, until we find out how to fill these fields
				date_default_timezone_set('America/Toronto');
                $date = new DateTime(); 
                $startDate = $date->format('Y-m-d H:i:s');
				$endDate = $date->add(new DateInterval('P1Y'));
				$endDate = $endDate->format('Y-m-d H:i:s');

				$client->licenseNumber = uniqid();
				$client->licenseStartDate = $startDate;
				$client->licenseEndDate = $endDate;
				$client->APIKey = "countrySearchKey";

				$client->insert();
				$client = $client->getByEmail($_POST['email']);
				
				echo '<script type="text/javascript">'; 
				echo 'alert("Account created successfully! Please log in.");';
				echo "window.location.href = '/WebServicesFinalProject/Client/ClientController/login';";
				echo '</script>';
			} else {
				$this->view('RegisterView'); 
			}
		}

		public function login() {
			if (isset($_POST['loginB'])) {
				// to check if credentials correspond to a client
				$client = new \WebServicesFinalProject\Client\models\ClientModel();
				$client = $client->getByEmail($_POST['email']);
   
			   // check if credentials are also valid
			   if($client != false && password_verify($_POST['password'], $client->passwordHash) ) {
				   $_SESSION['clientID'] = $client->clientID;
				   header('location: /WebServicesFinalProject/Client/ClientController/index');
				   //header('location:/ClientController/index');
				}
   
			   // if credentials are invalid, send error message
			   else {
				   $this->view('LoginView', 'Invalid username / password combination.');
			   }

		   } else 
			   $this->view('LoginView');
		}

		public function logout() {
			session_destroy();
			header('location:/WebServicesFinalProject/Client/ClientController/login');
			//header('location:/ClientController/login');
		}

		// Method to convert response headers to an array
		// Code from: https://blog.devgenius.io/how-to-get-the-response-headers-with-curl-in-php-2173b10d4fc5
		function headersToArray($str)
		{
			$headers = array();
			$headersTmpArray = explode("\r\n" , $str);
			for ($i = 0; $i < count($headersTmpArray); ++$i)
			{
				if (strlen($headersTmpArray[$i]) > 0)
				{
					if (strpos($headersTmpArray[$i], ":"))
					{
						$headerName = substr($headersTmpArray[$i] , 0 , strpos($headersTmpArray[$i] , ":"));
						$headerValue = substr($headersTmpArray[$i] , strpos($headersTmpArray[$i] , ":") + 1);
						$headers[$headerName] = $headerValue;
					}
				}
			}
			return $headers;
		}

		public function index() {
			if (isset($_POST['searchB'])) {
				// ---------------------- FIRST REQUEST -------------------
				
				// First, make sure client has a APIKey & valid license number, and generate token
				$clientId = $_SESSION['clientID'];
				$client = new \WebServicesFinalProject\Client\models\ClientModel();
				$client = $client->getById($clientId);

				$clientData = ["APIKey" => $client->APIKey,
						"licenseNumber" => $client->licenseNumber,
						"licenseEndDate" => $client->licenseEndDate];
				$jsonClientData = json_encode($clientData);

				$firstRequestHeaders = ['Content-type: application/json'];
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, "http://localhost/WebServicesFinalProject/WebService/api/auth/");
				curl_setopt($ch, CURLOPT_HTTPHEADER, $firstRequestHeaders);	
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonClientData);
				curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$responseData = curl_exec($ch);
				curl_close($ch);

				// Capture response headers & token (remove "bearer" from header value)
				$responseHeaderSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$responseHeaderStr = substr($responseData, 0, $responseHeaderSize);

				$headerArray = $this->headersToArray($responseHeaderStr);
 
				if (isset($headerArray['WWW-Authenticate'])) {
					$authenticatorValue = $headerArray['WWW-Authenticate'];
					$token = substr($authenticatorValue, 8);
				}
				else {
					$errorMessage = "You are not authorized to use this service. Please check your API key and license validity and try again.";
					$this->view('HomeView', $errorMessage);
					return;
				}

				// ---------------------- SECOND REQUEST -------------------
				
				// First make sure value was written if category is not "All Country Data"
				if (($_POST['category'] != 'All Country Data') && ($_POST['value'] == '')) {
					$errorMessage = "Please input a value.";
					$this->view('HomeView', $errorMessage);
					return;
				}

				// Then by storing the user data so it can be sent to web service
				$category = $_POST['category'];
				if (isset($_POST['value'])) {
					$value = $_POST['value'];
				}

				// Update certain category names to match a controller in Web Service
				switch ($category) {
					case 'All Country Data':
						$category = 'all';
						break;
					
					case 'Country Name':
						$category = 'name';
						break;
					
					case 'Full Country Name':
						$category = 'name';
						break;
					
					case 'Country Code':
						$category = 'alpha';
						break;
					
					case 'List of Country Codes':
						$category = 'alpha';
						break;
					
					case 'Language':
						$category = 'lang';
						break;
					
					case 'Capital City':
						$category = 'capital';
						break;
				}

				// Connect with Web Service using the user data
				$url = "http://localhost/WebServicesFinalProject/WebService/api/$category/";
				if (isset($value)) {
					$requestHeaders = ['Accept: application/json',
						'Content-Type: application/json',
						"Authorization: Bearer $token", 
						"Value: $value"];
				}
				else {
					$requestHeaders = ['Accept: application/json',
						'Content-Type: application/json', 
						"Authorization: Bearer $token",
						"Value: "];
				}
				
				// // $data = ['category' => $category, 
				// // 		 'value' => $value];

				$curl = curl_init();

				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $requestHeaders);
				// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				// curl_setopt($curl, CURLOPT_POST, true);
				// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
				// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
				// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

				$responseData = curl_exec($curl);
				echo $responseData;

				curl_close($curl);
			} else {
				$this->view('HomeView');
			}
		}
	}
?>