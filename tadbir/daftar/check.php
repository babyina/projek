<?php
require("../../parlimen/phpmailer/class.phpmailer.php");
$userId = $_GET['id'];
$sql = mysql_query("select nama, emel, sistem from pengguna where id = '$userId'");
$result = mysql_fetch_array($sql);
$userNama = $result[0];
$userEmel = $result[1];
$sistem = $result[2];

/******* PSU PROFIL ********/
$adminId = $_SESSION['userid'];
$adminNama = $_SESSION['nama'];
$query = mysql_query("select emel from pengguna where id = '$adminId'");
$rows = mysql_fetch_array($query);
$adminEmel = $rows[0];

if($_GET['action'] == "check"){
	$statusMohon = "TIDAK SAH";
	$qry = "UPDATE pengguna SET statusMohon = '$statusMohon' WHERE id = '$userId'";
	if(mysql_query($qry)){
		$mail = new PHPMailer();
		$mail->Host = "mye.treasury.gov.my"; // specify main and backup server
		$mail->IsSMTP();                         
		$mail->From = $adminEmel;//HEK to ADMIN
		$mail->FromName = $adminNama;
		//$mail->AddAddress($userEmel, $userNama);//email admin n nama
		//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "ADMIN");
		$mail->WordWrap = 50;
		$mail->IsHTML(true); 
		$mail->Subject = "Pengesahan Pendaftaran Pengguna ".$sistem;
		$mail->Body  = 	"Tuan/Puan,<br/><br/>" .
						"Maklumat pendaftaran pemohon <strong>$userNama</strong> didapati tidak tepat.<br/>" .
						"Sila berbincang.<br/><br/>" .
						"Untuk maklumat lanjut sila klik pautan berikut:<br/><br/>" .
						"<a href=\https://ssjp.treasury.gov.my/". "/tadbir/daftar/index.php?action=details&id=" . $userId. "\">" .
						"https://".$_SERVER['HTTP_HOST']."/ssjp/"."tadbir/daftar/index.php?action=details&id=" . $userId. "</a><br/><br/>" .
						
						"Sekian, harap maklum.<br/><br/><br/>" .
						"Yang menjalankan tugas,<br/><br/>" .
						"<strong>" . $adminNama . "</strong>";
		//echo $mail->Body;	
		$query = mysql_query("SELECT emel FROM pengguna WHERE roles LIKE '%1%'"); #get email admin 
		while($rows = mysql_fetch_array($query)){
			$email = $rows['emel'];
			//echo $email;
			$mail->AddAddress($email,"ADMIN");
		}
				
		if($mail->Send()){
			$error = 1;
		}	
								
		if($error > 0){
			echo "<br/><br/><br/><center>Emel telah dihantar kepada ADMIN untuk disemak semula.";
		}
	}
}
?>