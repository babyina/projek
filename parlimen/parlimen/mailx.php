<?php
$to	= "jamlee.yanggitom@treasury.gov.my";
$subject	= "subjek";
$message	= "mesej";

$a	= mail($to, $subject, $message);
if ($a)	
	echo 'berjaya';
else
	echo 'xberjaya';
?>