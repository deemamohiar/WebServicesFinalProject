<?php

    namespace WebServicesFinalProject\WebService\api;

    // require_once(dirname(__DIR__) . "\\api\\http\\RequestBuilder.php");

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
                            $this->post();
                            break;
                    }
                }
			}
        }

        public function get() {
            // TBD
            $responsePayload = json_encode($this->controller->index());
            // echo $responsePayload;
            // $requestPayload = file_get_contents('php://input');
        }

        public function post() {
            // not implemented
            echo "wtf";
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