<?php
    namespace WebServicesFinalProject\WebService\api;

    require_once(dirname(__DIR__) . "\\api\\http\\RequestBuilder.php");

    use WebServicesFinalProject\WebService\api\http\RequestBuilder;

    foreach (glob("C:/xampp/htdocs/WebServicesFinalProject/WebService/controllers/*.php") as $filename) {
        include $filename;
    }

    class API {
        public $request;
        private $controller;

        function __construct() {
            $requestBuilder = new RequestBuilder();
            $this->request = $requestBuilder->getRequest();

            // Get the params from URL
            $keys = array_keys($this->request->urlParams);
            // Determine which controller to load based on URL params
            if (file_exists(dirname(__DIR__) . '/controllers/' . $keys[0] . 'Controller.php')) {
                if (class_exists($keys[0] . 'Controller')) {
                    $this->controller = new ($keys[0] . 'Controller');
                   
                    switch ($this->request->method) {
                        case 'GET':      
                            $this->get();
                            break;
                        case 'POST':
                            $this->post($keys[0]);
							break;
                    }
                }
			}
        }

        public function get() {

            // get category chosen by user
            $_SESSION['category'] = $this->request->header['Category'];
            $clientID = $this->request->header['ClientID'];

            // if user has chosen get all countries, no need to check for user input
            if ($_SESSION['category'] == 'all') {
                json_encode($this->controller->index($clientID));
            }
            // if user has selected anything else, get their input
            else {
                $userInput = $this->request->header['Value'];
                json_encode($this->controller->index($clientID, $userInput));
            }

        }

        public function post($controllerName) {
            switch ($controllerName) {
				case "auth":
					$token = $this->controller->authenticateClient($this->request->payload);
					break;
			}
        }
    }

    $api = new API();
 
?>