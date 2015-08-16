<?php
try{
	$curl = curl_init();
	curl_setopt ($curl, CURLOPT_URL, $_GET['u']);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	echo curl_exec ($curl);
	curl_close ($curl);
}
catch (Exception $e)
{
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>