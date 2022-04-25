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
            $this->debug_to_console("lol");

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
            // TBD

            // check if user inputted anything or not
            // if(!isset($this->request->header['Value']) && get_class($this->controller) != 'AllController') {
            //     echo "<h1 style='color:red; text-align:center;'>No results found. Please try again with a different input.</h1>";
            //     echo "<a style='padding-left:47%; font-size: 25px;' href='/WebServicesFinalProject/Client/ClientController/index'>Search again</a>";
            //     return;
            // }
            if (get_class($this->controller) == 'AllController') {
                json_encode($this->controller->index());
            }
            else {
                $userInput = $this->request->header['Value'];
                $responsePayload = json_encode($this->controller->index($userInput));
            }
            // echo $responsePayload;
            // $requestPayload = file_get_contents('php://input');
        }

        public function post($controllerName) {
            switch ($controllerName) {
				case "auth":
					$token = $this->controller->authenticateClient($this->request->payload);
					break;
			}
        }

        
        public function debug_to_console($data) {
            $output = $data;
            if (is_array($output))
                $output = implode(',', $output);
        
            echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
        }

    }

    $api = new API();

    // // These are for texting purposes
    // echo "<br><br>";
    // echo "Value: ";
    // echo "<br>";
    // echo "----------------------------";
    // echo "<br>";
    // print_r($api->request->urlParams);
    // echo "<br><br>";

    // echo "METHOD: ";
    // echo "<br>";
    // echo "----------------------------";
    // echo "<br>";
    // echo $api->request->method;
    // echo "<br><br>";

    // echo "HEADERS: ";
    // echo "<br>";
    // echo "----------------------------";
    // echo "<br>";
    // print_r($api->request->header);

 
?>