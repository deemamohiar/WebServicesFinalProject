<?php
	
    // SO I'm guessing this will be deleted in future
    // reference, it's just in the meantime while we want
    // to do some testing 

	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, "http://localhost/WSFinalProj/api/index.php?all");
	
	$requestheaders = ['accept: application/json'];
	curl_setopt($ch, CURLOPT_HTTPHEADER, $requestheaders);
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$responsedata = curl_exec($ch);	
	echo $responsedata;

	curl_close($ch);
?>