<?php
require("include/phpmailer/class.phpmailer.php");

$mail = new PHPMailer();
$mail->IsSMTP();                                     
//$mail->Host = "mye.treasury.gov.my"; // specify main and backup server
//$mail->SMTPAuth = true;     // turn on SMTP authentication
//$mail->Username = "Shahrudin bin Md Nor";  // SMTP username
//$mail->Password = "pass2kwp,"; // SMTP password

$mail->From = "jamlee.yanggitom@treasury.gov.my";
$mail->FromName = "Sistem Pengesanan Soal Jawab Parlimen ";
//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "shahrudin");
$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "nyork");
//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "rizal");
//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "nyork");
//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "nyork");
//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "nyork");
$mail->AddReplyTo("jamlee.yanggitom@treasury.gov.my", "Test");

$mail->WordWrap = 50;                                 // set word wrap to 50 characters
$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = "Sila abaikan email ini. TESTING PURPOSES.";
$mail->Body    = "Email ini adalah dari <b>SPMJM!</b>";
$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message has been sent";
?>