<?php
require("../../parlimen/phpmailer/class.phpmailer.php");
$userId = $_GET['id'];
$sql = mysql_query("select nama, emel, sistem from pengguna where id = '$userId'");
$result = mysql_fetch_array($sql);
$userNama = $result[0];
$userEmel = $result[1];
$sistem = $result[2];

/******* ADMIN PROFIL ********/
$adminId = $_SESSION['userid'];
$adminNama = $_SESSION['nama'];
$query = mysql_query("select emel from pengguna where id = '$adminId'");
$rows = mysql_fetch_array($query);
$adminEmel = $rows[0];

//  send email to admin utk  daftar 
if($_GET['action'] == "sah"){
	$statusMohon = "SAH";
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
						"Maklumat pendaftaran pemohon <strong>$userNama</strong> untuk <strong>Sistem Pengesanan Soal Jawab Parlimen</strong> telah disahkan betul.<br/><br/>" .
						"Sekian, untuk tindakan tuan selanjutnya.<br/><br/><br/>" .
						"Untuk tindakan pendaftaran permohonan sila klik pautan berikut:<br/>" .
						"<a href=\https://ssjp.treasury.gov.my/". "/tadbir/daftar/index.php?action=details&id=" . $userId. "\">" .
						"https://".$_SERVER['HTTP_HOST']."/ssjp/"."tadbir/daftar/index.php?action=details&id=" . $userId. "</a><br/><br/>" .
						"Yang menjalankan tugas,<br/><br/>" .
						"<strong>" . $adminNama . "</strong><br/>".
						"Pegawai Setiausaha";
			
		//echo $mail->Body;			
		/*
		$query = mysql_query("SELECT roles, emel FROM pengguna");
		$roles_array = array();
		while($rows = mysql_fetch_array($query)){
			$roles_array[$rows[0]] = $rows[1];
		}
		
		$error = 0;
		foreach($roles_array as $role => $email){
			$roles = explode("+", $role);
			foreach($roles as $r){
				if($r == 1){
					$mail->AddAddress($email,"ADMIN");
					//echo $email;
					if($mail->Send()){
						$error = 1;
					}
				}
			}
		}
		*/
		
				// GET ADMIN EMAIL
		$query = mysql_query("SELECT emel FROM pengguna WHERE roles LIKE '%1%'");
		while($rows = mysql_fetch_array($query)){
			$email = $rows['emel'];
		//	echo $email;
			$mail->AddAddress($email,"ADMIN");
		}
		
		if($mail->Send()){
			$error = 1;
			//echo $mail->Body;	
		}		
		
		if($error > 0){
			echo "<br/><br/><br/><center>Emel telah dihantar kepada ADMIN untuk pendaftaran.";
		}
	}
}
?>