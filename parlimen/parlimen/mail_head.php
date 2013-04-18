<?php 
$mail = new PHPMailer();
$mail->IsSMTP();                                     
//$mail->Host = "mye.treasury.gov.my"; // specify main and backup server
$mail->Host="zmproxy1.treasury.gov.my"; 
$mail->SMTPAuth = false;     // turn on SMTP authentication
//$mail->Username = "";  // SMTP username
//$mail->Password = ""; // SMTP password

$mail->From = "jamlee.yanggitom@treasury.gov.my";
$mail->FromName = "Sistem Pengesanan Soal Jawab Parlimen";
$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "test");
?>