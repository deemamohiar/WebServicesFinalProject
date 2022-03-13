<?php
	
    // SO I'm guessing this will be deleted in future
    // reference, it's just in the meantime while we want
    // to do some testing 

	$curl = curl_init();
	
	curl_setopt($curl, CURLOPT_URL, "http://localhost/WSFinalProj/api/index.php?all");
	
	$requestheaders = ['accept: application/json'];
	curl_setopt($curl, CURLOPT_HTTPHEADER, $requestheaders);
	
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
	$responsedata = curl_exec($curl);	
	echo $responsedata;

	curl_close($curl);
?>