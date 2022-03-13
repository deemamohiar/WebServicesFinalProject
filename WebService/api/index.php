<?php
    require_once(dirname(__DIR__) . "\\api\\http\\RequestBuilder.php");

    spl_autoload_register(
        function ($class_name) { 
            include (dirname(__DIR__) . '/controllers/' . $class_name . '.php'); 
        }
    ); 

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
                            $this->post();
                            break;
                    }
                }
			}
        }

        public function get() {
            // TBD
            switch ($this->request->header['accept']) {
                case 'application/json':
                    $responsePayload = json_encode($this->controller->index());
                    // echo $responsePayload;
                    break;

                // handle other formats
            }
        }

        public function post() {
            // not implemented
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