<?php
	namespace Client\controllers;
	use DateTime;

	class ClientController extends \Client\core\Controller {
		public function login() {
			if (isset($_POST['loginB'])) {
				// to check if credentials correspond to a client
				$client = new \Client\models\ClientModel();
				$client = $client->getByEmail($_POST['email']);
   
			   // check if credentials are also valid
			   if($client != false && password_verify($_POST['password'], $client->password_hash) ) {
				   $_SESSION['clientID'] = $client->clientID;
				   header('location:/ClientController/index');
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
		
				$client = new \Client\models\ClientModel();
		
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
				echo "window.location.href = '/ClientController/login';";
				echo '</script>';
			} else {
				$this->view('RegisterView'); 
			}
		}
	}
	

	// $curl = curl_init();
	
	// curl_setopt($curl, CURLOPT_URL, "http://localhost/Client/api/index.php?all");
	
	// $requestheaders = ['accept: application/json'];
	// curl_setopt($curl, CURLOPT_HTTPHEADER, $requestheaders);
	
	// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
	// $responsedata = curl_exec($curl);	
	// echo $responsedata;

	// curl_close($curl);
?>