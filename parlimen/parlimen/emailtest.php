<?php

/* @uses mysql configuration */
//$host="localhost";
//$user="root";
//$pass="";

//$db_voffice = 'par_kab_test';  //database par_kab
//$db_voffice = 'kwp';
//$conn = mysql_connect($host,$user,$pass) or die(mysql_error());
//mysql_select_db($db_voffice,$conn) or die(mysql_error());

function sendToPegawai($conn,$subject,$message){						
	$email = "jamlee.yanggitom@treasury.gov.my";
	$headers = "From: jamlee.yanggitom@treasury.gov.my\n";		
	if(mail($email,$subject,$message,$headers)){		
		return $email;
	}else
		return false;
}
	
$id = "30";
$subject = "SUBJEK\n";
$link_parlimen="http://192.168.105.173/parlimen/login.php?action=details&id=";
$url = $link_parlimen.$id; 		
$message = "Sila klik URL maklumat lanjut\n\n$url";	
if($msg = sendToPegawai($conn,$subject,$message)){
		echo "<center><font class=subheader1><br/> Emel telah dihantar kepada </font><br/><br/>";
		echo $msg."</center>";
}			
	
?>