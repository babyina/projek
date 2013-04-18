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

if($_GET['action'] == "tolak"){
	$statusMohon = "DITOLAK";
	$qry = "UPDATE pengguna SET statusMohon = '$statusMohon' WHERE id = '$userId'";
	if(mysql_query($qry)){
		$mail = new PHPMailer();
		$mail->Host = "mye.treasury.gov.my"; // specify main and backup server
		$mail->IsSMTP();                         
		$mail->From = $adminEmel;//HEK to ADMIN
		$mail->FromName = $adminNama;
		$mail->AddAddress($userEmel, $userNama);//email admin n nama
		//$mail->AddAddress("ruzzo_abi@yahoo.com", "FENDY");
		$mail->WordWrap = 50;
		$mail->IsHTML(true); 
		$mail->Subject = "Kelulusan Pendaftaran Sistem Pengesanan Soal Jawab Parlimen";
		$mail->Body  = 	"Tuan/Puan,<br/><br/>" .
						"Dukacita dimaklumkan permohonan tuan untuk menjadi  pengguna Sistem Pengesanan Soal Jawab Parlimen ditolak.<br/><br/>" .
						"Segala kesulitan amat dikesali.<br/><br/>" .
						"Sekian, terima kasih.<br/><br/>" .
						"Yang menjalankan tugas,<br/><br/>" .
						"<strong>" . $adminNama . "</strong>";
	//	echo $mail->Body;
		if($mail->Send()){
			echo "<br/><br/><br/><center>Permohonan pengguna <strong>" . $userNama . "</strong> telah ditolak.<br/>";
			echo "Emel telah dihantar kepada pengguna untuk pemberitahuan.";
		}
	}
}
?>