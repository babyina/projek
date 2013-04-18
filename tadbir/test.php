<?php

require("../parlimen/phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->Host = "mye.treasury.gov.my"; // email ADMIN
	$mail->IsSMTP();                         
	$mail->From = $userEmel;//email ADMIN
	$mail->FromName = "ADMIN";
	//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "ADMIN");//email admin n nama

	$mail->WordWrap = 50;
	$mail->IsHTML(true); 
	$mail->Subject = "Pengesahan Pendaftaran Pengguna Sistem Parlimen";
 	$mail->Body  =  "Tuan/Puan,<br/><br/>" .
					"Dikemukakan maklumat pendaftaran pengguna <strong>$sistem</strong> untuk pengesahan Tuan.<br/><br/>" .
					"2) Disertakan memo kelulusan daripada bahagian HEK seperti berikut:<br/><br/>" .
					"_______________________________________________________________________________________________<br/><br/>".
						"Tuan/Puan,<br/><br/>" .
						"Sukacita dimaklumkan bahawa pihak HEK bersetuju dengan permohonan <b>" . $nama . "</b> " .
						"untuk menjadi pengguna <b>$sistem</b><br/><br/>" .
						"Sekian, untuk tindakan tuan selanjutnya.<br/><br/>" .
						"Yang menjalankan tugas,<br/><br/>" . 
						"<b> Pegawai HEK </b><br/><br/>".								
					"_______________________________________________________________________________________________<br/><br/>".
					"3) Untuk tindakan pengesahan maklumat permohonan sila klik pautan berikut:<br/><br/>" .
					"<a href=\http://garuda/ssjp/". "/admin/login.php?action=details&app=psu&id=" . $id. "\">" .
					"http://".$_SERVER['HTTP_HOST']."/ssjp/"."admin/login.php?action=details&app=psu&id=" . $id. "</a><br/><br/>" .
					"Sekian, untuk perhatian dan pengesahan tuan.<br/><br/>" .
					"Yang menjalankan tugas,<br/><br/>" .
					"<strong>" . $user . "</strong>";
	

		$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "PSU");
		if($mail->Send()){
			echo $mail->Body;
		}
	
?>