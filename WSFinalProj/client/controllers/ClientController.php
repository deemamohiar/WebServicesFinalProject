<?php
	namespace WSFinalProj\client\controllers;
    // SO I'm guessing this will be deleted in future
    // reference, it's just in the meantime while we want
    // to do some testing 

	class ClientController extends \WSFinalProj\core\Controller {
		public function login() {
			if (isset($_POST['loginB'])) {
				// to check if credentials correspond to a client
				$client = new \WSFinalProj\client\models\ClientModel();
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
   
			   // while button is not clicked
		   } else 
			   $this->view('LoginView');
		}
	}
	

	// $curl = curl_init();
	
	// curl_setopt($curl, CURLOPT_URL, "http://localhost/WSFinalProj/api/index.php?all");
	
	// $requestheaders = ['accept: application/json'];
	// curl_setopt($curl, CURLOPT_HTTPHEADER, $requestheaders);
	
	// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
	// $responsedata = curl_exec($curl);	
	// echo $responsedata;

	// curl_close($curl);
?>