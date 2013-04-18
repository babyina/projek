<?php
echo 'Test Mail';
echo '<br>';
$headers = "From: jamlee.yanggitom@treasury.gov.my";
if(mail("jamlee.yanggitom@treasury.gov.my",'subjek','mesej',$headers))
	echo "Berjaya";
else
	echo "Tak berjaya";
	
	
//METHOD : PHPMAILER
/*
	require("phpmailer/class.phpmailer.php");
	$isi = "<b>Kata Laluan Baru</b><br><br>Assalammualaikum dan Salam Sejahtera,<br><br>Adalah dengan ini dimaklumkan email ini dihantar daripada sistem Permohonan Jawatan MARDI untuk memaklumkan bahawa kata laluan anda telah berjaya dikemaskini.<br><br>Sila masuk ke sistem MARDI di alamat <a href='http://www.mardi.my/jawatan/' target='_blank'>http://www.mardi.my/jawatan/</a> untuk masuk ke sistem. Sila simpan kata laluan baru anda dengan baik:<br><br>   No. Kad Pengenalan: $noKP <br>   Kata Laluan: $password <br><br>Sekian terima kasih.<br><br>p/s - Jangan balas email ini.";

	$sender = "temporary1@mardi.my";
	$header = "X-Mailer: PHP/".phpversion() . "Return-Path: $sender";
	$mail = new PHPMailer();

	$mail->IsSMTP();                                      // set mailer to use SMTP
	$mail->Host = "mail.mardi.my;agromedia.mardi.my";  // specify main and backup server
	$mail->SMTPAuth = false;     // turn on SMTP authentication
	
	$mail->From = $sender;
	$mail->FromName = "MARDI";
	$mail->AddAddress($email_receiver);                  // name is optional
	$mail->AddReplyTo($sender, "MARDI");
	
	//$mail->WordWrap = 50;                                 // set word wrap to 50 characters
	$mail->IsHTML(true);                                  // set email format to HTML
	$mail->CreateHeader($header);
	$mail->Subject = "Kata Laluan Baru";
	$mail->Body    = $isi;
	$mail->AltBody = $isi;
	$mail->Send();
*/

/*
require("include/mail.inc.php");

// Instantiate your new class
$mail = new MyMailer;

$mail->SMTPAuth = true;     							// turn on SMTP authentication
$mail->Username = "";  					// SMTP username
$mail->Password = ""; 						// SMTP password

// Now you only need to add the necessary stuff
$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "Rizal");
$mail->AddAddress("sukabatik@yahoo.com", "Laili");
$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "Norharizal Ishak");
$mail->Subject = "Dari server kwp";
$mail->Body    = "Wallawwweeehhh";
//$mail->AddAttachment("c:/temp/11-10-00.zip", "new_name.zip");  // optional name

if(!$mail->Send())
{
   echo "There was an error sending the message";
   exit;
}

echo "Message was sent successfully";
*/


//METHOD : mail
/*
	$send = true;

	$emel = 'jamlee.yanggitom@treasury.gov.my'
	$perkara = "Jadual Pegawai Bertugas";
	$subject = $perkara;
	$message = "Anda dikehendaki bertugas pada hari dan sesi yang telah ditetapkan. \n\n".
				"Penggal   : $penggal \n Parlimen  : $parlimen \n".
				"Mesyuarat : $mesyuarat \n Sesi      : $sesi \n\n".
				"Tarikh    : $Tarikh \n Sesi      : $Sesi \n\n".
				"Untuk maklumat selanjutnya sila klik \n\n$url";	
	$headers = "From: jamlee.yanggitom@treasury.gov.my";
		
	if(mail($emel,$subject,$message,$headers))
		echo "Berjaya";
	else
		$send = false;
		echo "Tak Berjaya";
	
	if($send)
	{
		$msg = "<center><br /><br />Jadual Pegawai Bertugas telah disimpan. <br /><br />Emel pemberitahuan telah dihantar kepada pegawai-pegawai bertugas.</center>";
	}
*/

?>