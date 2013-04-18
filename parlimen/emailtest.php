<?php
include("config.php");
/* @uses mysql configuration */
//$host="localhost";
//$user="root";
//$pass="";

//$db_voffice = 'par_kab_test';  //database par_kab
//$db_voffice = 'kwp';
//$conn = mysql_connect($host,$user,$pass) or die(mysql_error());
//mysql_select_db($db_voffice,$conn) or die(mysql_error());

//function sendToPegawai($conn,$subject,$message){						
//	$email = "sukabatik@yahoo.com,jamlee.yanggitom@treasury.gov.my,sukabatik@gmail.com";
//	$headers = "From: jamlee.yanggitom@treasury.gov.my\n";		
//	if(mail($email,$subject,$message,$headers)){		
//		return $email;
	//}else
	//	return false;
//}


	
	function sendToPegawai($conn,$subject,$message){	
		require("phpmailer/class.phpmailer.php");
		$agensi_id =3;
		$result = mysql_query("SELECT emel FROM pengguna WHERE agensi_id='$agensi_id'",$conn) or die(mysql_error());

		$row = mysql_fetch_array($result);
		echo $row['emel'];	
		//$emel= $row['emel'];		

		//echo $emel;
		//$email_temp = explode(",",$address);
		include("mail_head.php");
		//foreach ($email_temp as $mail)
		//{
		//if($agensi_id==3)
			//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "Pegawai");
			
		//}
		//if($agensi_id==3)
			$email = $row['emel'];
		
		$mail->AddAddress("jamlee.yanggitom@treasury.gov.my,jamlee.yanggitom@treasury.gov.my", "Test");
		$mail->AddReplyTo("jamlee.yanggitom@treasury.gov.my", "Test");

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = "Perkara";
		$mail->Body    = $message;
		$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

		if(!$mail->Send())
		{
  		 echo "Message could not be sent. <p>";
   			echo "Mailer Error: " . $mail->ErrorInfo;
  		 exit;
		}
		else{		
			return $email;
			echo "Message has been sent";
		}
		//echo $address;		
		//$headers = "From: \n";	
		//if(mail($address,$subject,$message,$headers)){			
		//	return $address;
		//}else
			//return false;
	}	
$id = "39";
$subject = "SUBJEK\n";
$link_parlimen="http://192.168.105.173/parlimen/login.php?action=details&id=";
$url = $link_parlimen.$id; 		
$message = "Sila klik URL maklumat lanjut\n\n$url";	
if($msg = sendToPegawai($conn,$subject,$message)){
		echo "<center><font class=subheader1><br/> Emel telah dihantar kepada </font><br/><br/>";
		echo $msg."</center>";
}			
	
?>