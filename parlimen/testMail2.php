<?php
	require("phpmailer/class.phpmailer.php");

	$mail = new PHPMailer();

	$mail->IsSMTP();                                   // send via SMTP
	$mail->Host     = "10.10.10.11"; // SMTP servers
	$mail->SMTPAuth = false;     // turn on SMTP authentication
	//$mail->Username = "jswan";  // SMTP username
	//$mail->Password = "secret"; // SMTP password

	$mail->From     = "jamlee.yanggitom@treasury.gov.my";
	$mail->FromName = "Norfizah";
	$mail->AddAddress("jamlee.yanggitom@treasury.gov.my","Rizal"); 
	//$mail->AddAddress("ellen@site.com");               // optional name
	$mail->AddReplyTo("info@site.com","Information");

	$mail->WordWrap = 50;                              // set word wrap
	//$mail->AddAttachment("/var/tmp/file.tar.gz");      // attachment
	//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); 
	//$mail->IsHTML(true);                               // send as HTML

	$mail->Subject  =  "Here is the subject";
	//$mail->Body     =  "This is the <b>HTML body</b>";
	$mail->AltBody  =  "This is the text-only body";

	if(!$mail->Send())
	{
	   echo "Message was not sent <p>";
	   echo "Mailer Error: " . $mail->ErrorInfo;
	   exit;
	}

	echo "Message has been sent";
	
?>