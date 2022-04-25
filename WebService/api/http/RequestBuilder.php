<?php 

namespace WebServicesFinalProject\WebService\api\http;

use WebServicesFinalProject\WebService\api\http\Request;

require_once("Request.php");

    class RequestBuilder {
        private $request;

        function getRequest() {
            $this->request = new Request();

            $this->request->method = $_SERVER['REQUEST_METHOD'];
            $this->request->header = apache_request_headers();

            // We're retrieving the key from the params found in URL
            $key = array_keys($_GET)[0];
            
            if (isset($_GET[$key])) {
                $this->request->urlParams = $_GET;

                // // I'm guessing we will have to edit these in future time
                // echo "Parse URL: " . "<br>";
                // var_dump($this->parseURL());
            }

            if ($this->request->method == "POST") {
				$this->request->payload = file_get_contents('php://input');
			}

            return $this->request;
        }

        public function parseURL() {
            if(isset($_GET['url'])) {
                return explode('/', 
                    filter_var(
                        rtrim($_GET['url'], '/'), 
                        FILTER_SANITIZE_URL)
                );
            }
        }
    }
?> 