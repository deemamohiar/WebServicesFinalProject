<?php
	namespace controllers;
	require("C:\\xampp\\htdocs\\WebServicesFinalProject\\Client\\core\\Controller.php");
	require("C:\\xampp\\htdocs\\WebServicesFinalProject\\Client\\models\\ClientModel.php");

	use DateTime;

	class ClientController extends \WebServicesFinalProject\Client\core\Controller {
		
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
                $tempTime = new DateTime(); 
                $tempTime = $tempTime->format('Y-m-d H:i:s');

				$client->licenseNumber = "";
				$client->licenseStartDate = $tempTime;
				$client->licenseEndDate = $tempTime;
				$client->APIKey = "";

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

		public function logout() {
			session_destroy();
			header('location:/WebServicesFinalProject/Client/ClientController/login');
			//header('location:/ClientController/login');
		}

		public function index() {
			if (isset($_POST['searchB'])) {
				// Start by storing the user data so it can be sent to web service
				$category = $_POST['category'];
				$value = $_POST['value'];

				// Update certain category names to match a controller in Web Service
				// In certain cases, also update "value" to match API formatting
				switch ($category) {
					case 'All Country Data':
						$category = 'all';
						break;
					
					case 'Country Name':
						$category = 'name';
						break;
					
					case 'Full Country Name':
						$category = 'name';
						$value = $value . '?fullText=true';
						break;
					
					case 'Country Code':
						$category = 'alpha';
						break;
					
					// ---------------TO DO LATER----------------
					// case 'List of Country Codes':
					// 	$category = 'alpha';
					// 	$
					// 	break;
					
					case 'Language':
						$category = 'lang';
						break;
					
					case 'Capital City':
						$category = 'capital';
						break;
				}

				// ARE WE SUPPOSED TO USE CURL HERE OR NOT WTF
				// So here's the thing, I think we are, but I don't understand
				// how to use curl to follow location, because right now
				// it's staying at ClientController instead of going to api/index.php

				// Connect with Web Service using the user data
				$url = "http://localhost/WebServicesFinalProject/WebService/api/$category/";

				$requestHeaders = ['Accept: application/json',
								   'Content-Type: application/json', 
								   "Value: $value"];
				// $data = ['category' => $category, 
				// 		 'value' => $value];

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

				// This is a temporary solution until I figure out curl
				// header('location: /WebService/api/index.php?' . $category . '?' . $value);
			} else {
				$this->view('HomeView');
			}
		}
	}
?>