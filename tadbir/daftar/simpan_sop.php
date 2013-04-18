<?php
require("../../parlimen/phpmailer/class.phpmailer.php");

$valid = "true";
$id = $_GET['id'];
$sistem = $_POST['Sistem'];
//$sistem = "Sistem Pentadbiran";
$nama = addslashes ($_POST['Nama2']);
$agensi = $_POST['Agensi'];
$jawatan = $_POST['Jawatan'];
$telefon = $_POST['Code']."-".$_POST['Telefon'];
$hp = $_POST['Pre_num']."-".$_POST['Handphone']; 

$emel = $_POST['Emel'];
$emel2 = $_POST['Emel_jab'];
$id_nama = $_POST['Idkp'];
$idldap= $_POST['LDAP'];

//echo "ldap".$idldap;
//$cb = implode("+",$_POST['cb']);
$roles_id = is_array($_POST['cb'])?implode("+",$_POST['cb']):$_POST['cb'];  

if(strlen($_POST['edit']) > 0){
	if($_POST['changePwd']){
		$password = $_POST['Katalaluan'];
	}else{
		$password = $_POST['password'];
	}
}else{
	$password = $_POST['Katalaluan'];
	$password_ori =$_POST['Katalaluan'];
}

//$s = mysql_query("select id from roles order by id");
//$i = 0;
//while($r = mysql_fetch_array($s)){
//	$i++;
//	if($_POST['cb'.$i]){
//		$roles .= $_POST['cb'.$i] . "+";
		//$roles .= $roles . "+";
//	}
//}

//foreach($cb AS $key)
//{
	//$roles .= $sap . $key;
	//$sap = "+";
//}
//echo $roles;

$modul1 = ($_POST['mod1'])? $_POST['mod1']:0;
$modul2 = ($_POST['mod2'])? $_POST['mod2']:0;
$modul3 = ($_POST['mod3'])? $_POST['mod3']:0;
$modul4 = ($_POST['mod4'])? $_POST['mod4']:0;
$modul5 = ($_POST['mod5'])? $_POST['mod5']:0;
$modul6 = ($_POST['mod6'])? $_POST['mod6']:0;
$tkh_daftar = $_POST['tkh_daftar'];
$pendaftar = $_POST['pendaftar'];
$parlimen = $_POST['parlimen'];
$kabinet = $_POST['kabinet'];
$status = $_POST['status'];

$errmsg = array();



	/********* HEK PROFIL **********/
	$user = $_SESSION['nama'];
	$userid = $_SESSION['userid'];
	$query = mysql_query("select emel from pengguna where id = '$userid' or nokp='$userid'");
	$result = mysql_fetch_array($query);
	$userEmel = $result[0];
	
	//if($_POST['SimpanLDAP']=="DAFTAR"){	
		//$sistem="Sistem Soal Jawab Parlimen";
		//echo "LDAP";
		/*********** VALIDATION USERID AND EMAIL ***********/
			//if(($statusMohon == "DAFTAR") && $isNewDoc)
			//{
			//if(empty($emel) || !eregi("^[A-Za-z0-9\_-]+@[A-Za-z0-9\_-]+.[A-Za-z0-9\_-]*", $emel))
			//if(empty($emel) || !eregi("^[[:alnum:]][a-z0-9_-]+.[a-z0-9_-]+@[a-z0-9.-]+\.[a-z]{2,4}$*",$emel))
			if(empty($emel) || !eregi("^[a-z0-9_-]+.[a-z0-9_-]+@[a-z0-9.-]+\.[a-z]$*",$emel))
				$errmsg[] = "Alamat group emel ($emel) tidak sah, sila masukkan semula";
				
				
				if(empty($emel2) || !eregi("^[a-z0-9_-]+.[a-z0-9_-]+@[a-z0-9.-]+\.[a-z]$*",$emel2))
				$errmsg[] = "Alamat emel jabatan ($emel2) tidak sah, sila masukkan semula";
	
	
			$query = "SELECT nokp FROM pengguna WHERE nokp = '$id_nama'";
			$result = mysql_query($query,$conn) or die(mysql_error());
			if(mysql_num_rows($result)<>0)
				$errmsg[] = "ID ($id_nama) telah wujud. Sila pilih ID lain";
				
			if(!empty($errmsg)){
				$valid = "false";
				echo "<br><br>";
			}		
		if($_POST['SimpanLDAP']=="DAFTAR"){	
		$sistem="Sistem Soal Jawab Parlimen";
			
			if($valid=="true"){
				$qry = 	"INSERT INTO pengguna " .
						"(sistem,nama,kod_ldap,agensi_id,jawatan,telefon,handphone,emel,emel_jab,nokp," .
						"roles,modul1,modul2,modul3,modul4,modul5,modul6,user,date) " .	
						"VALUES " .	
						"('$sistem','$nama','$idldap','$agensi','$jawatan','$telefon','$hp','$emel','$emel2','$id_nama'," .
						"'$roles_id','$modul1','$modul2','$modul3','$modul4','$modul5','$modul6','$user',now())";
						//echo $qry ;
						mysql_query($qry,$conn);
			}else{
			
				foreach($errmsg as $value)
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<font class=\"fs\">* $value</font><br>";
				}
				include("subform_treasury.php");
				exit(0);
			}
		//}
		//start here
		//$emel="zaidi.ahmad@treasury.gov.my";
		//$id_nama="zaidi";
		 $mail = new PHPMailer();
				//$mail->Host = "mye.treasury.gov.my";
				$mail->Host = "zmta1.treasury.gov.my";
				
				//$mail->IsSMTP();  **betulkan disini
				$mail->IsSendmail();  			 
				$mail->From = $userEmel;
				$mail->FromName = "Pentadbir Sistem";
				//$mail->FromName = $user;// nama sender asal pada 16 feb 2009
				//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "ADMIN");//email admin - penerima
				//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "ADMIN");//
				$mail->WordWrap = 50;
				$mail->IsHTML(true); 
				$mail->Subject = "Kelulusan Pendaftaran Pengguna";
							$mail->Body   = "YBHG. TAN SRI/DATO'/Tuan/Puan,<br/><br/>" .
								"Sukacita dimaklumkan bahawa permohonan YBHG. TAN SRI/DATO'/Tuan/Puan ".
								"telah didaftarkan sebagai pengguna Sistem Soal Jawab Parlimen(SSJP).<br/><br/>" .
								"2) YBHG. TAN SRI/DATO'/Tuan/Puan hendaklah menggunakan katalaluan email perbendaharaan<br/><br/>".													 
								"3) YBHG. TAN SRI/DATO'/Tuan/Puan hendaklah memaklumkan kepada Pentadbir Sistem sekiranya tidak lagi menggunakan SSJP.<br/><br/>".
								"4) SSJP boleh dicapai melalui <b> https://ssjp.treasury.gov.my </b> <br/><br/>".
								"5) Sebarang pertanyaan  mengenai sistem ini boleh dikemukakan kepada ssjp@treasury.gov.my atau menghubungi pegawai - pegawai berikut.<br/><br/>". 

								  "<table width=302 border=1 align=center>".
                                    "<tr>".
                                     "<td width=97><div align=center><strong>Nama</strong></div></td>".
                                     "<td width=89><div align=center><strong>No. Samb.</strong></div></td>".
                                 			
									 "</tr>".
								     "<tr>".
                                     "<td><div align=center>En. Asman Abdullah Bin Hasrat (0388906447)</div></td>".
                                     //"<td><div align=center>3591</div></td>".
                                     "</tr>". 
								   "</tr>".
								     "<tr>".
                                     "<td><div align=center>En. Zaidi Bin  Ahmad (0388823591)</div></td>".
                                     //"<td><div align=center>3591</div></td>".
                                     "</tr>".
                                     "<tr>".
                                   "<td><div align=center>En.Muhamad Faizal Bin. Pauzi(0388823644)</div></td>".
                                   //"<td><div align=center>03-88823644</div></td>".
                                    "</tr>".
                                     "<tr>".
                                     "<td><div align=center>Puan  Masitah Bt. Yaakub(0388824769)</div></td>".
                                    // "<td><div align=center>03-88824769</div></td>".
                                     "</tr>".
                                   "</table>".

								     
								"<br><br>Sekian, terima kasih<br/><br/>" .
								//"<a href=\ ."http://".$_SERVER['HTTP_HOST']."/ssjp/"."admin/daftar/index.php?action=details&app=yes&id=" . $id. "\">" .
								// ."http://".$_SERVER['HTTP_HOST']."/ssjp/"."admin/daftar/index.php?action=details&app=yes&id=" . $id. "</a><br/><br/>" .
								"Yang menjalankan tugas,<br/><br/>" . 
								//"<b>" . $user . "</b>"; asal pada 16 feb 2009
								 "<b>" . "Pentadbir Sistem" . "</b>";
								
								
				//echo $mail->Body;
				$mail->AddAddress($emel2,$nama );
				if($mail->Send()){
					$error = 1;
				}	
				if($error > 0){
					echo "<br><br><br><center>Pendaftaran berjaya . Emel telah dihantar kepada $nama";
				}							
			
		    //end  here
			//echo "<br><br><br><center>Rekod telah disimpan.";
			echo "<br><br><br><center><a href=\"index.php?action=list\">kembali semula</a></center>";
			
		}	
		
		
		//for agensi simpan
		if($_POST['SimpanAgensi']=="DAFTAR"){	
		
					if($valid=="true"){
				 $qry = 	"INSERT INTO pengguna " .
						"(sistem,nama,kod_ldap,agensi_id,jawatan,telefon,handphone,emel,emel_jab,nokp," .
						"password,roles,modul1,user,date) " .	
						"VALUES " .	
						"('$sistem','$nama','$idldap','$agensi','$jawatan','$telefon','$hp','$emel','$emel2','$id_nama'," .
						"MD5('$password'),'$roles_id','$modul1','$user',now())"; 
						
						mysql_query($qry,$conn);
						//echo $qry ;
						}
						
						else{
			
				foreach($errmsg as $value)
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<font class=\"fs\">* $value</font><br>";
				}
				
				include("subform_agensi.php"); 
				exit(0); 
			}
		//}
		   //start here
		//$emel="zaidi.ahmad@treasury.gov.my";
		//$id_nama="zaidi";
		 $mail = new PHPMailer();
				//$mail->Host = "mye.treasury.gov.my";
				$mail->Host = "zmta1.treasury.gov.my";
				
				//$mail->IsSMTP();  **betulkan disini
				$mail->IsSendmail();  			 
				$mail->From = $userEmel;
				$mail->FromName = "Pentadbir Sistem";
				//$mail->FromName = $user;// nama sender asal pada 16 feb 2009
				//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "ADMIN");//email admin - penerima
				//$mail->AddAddress("jamlee.yanggitom@treasury.gov.my", "ADMIN");//
				$mail->WordWrap = 50;
				$mail->IsHTML(true); 
				$mail->Subject = "Kelulusan Pendaftaran Pengguna";
							$mail->Body   = "YBHG. TAN SRI/DATO'/Tuan/Puan,<br/><br/>" .
								"Sukacita dimaklumkan bahawa permohonan YBHG. TAN SRI/DATO'/Tuan/Puan ".
								"telah didaftarkan sebagai pengguna Sistem Soal Jawab Parlimen(SSJP).<br/><br/>" .
								"2) Katalaluan YBHG. TAN SRI/DATO'/Tuan/Puan adalah seperti berikut:<br/><br/>".
									"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Katalaluan : $password_ori<br/><br/>".
								  
								"3) YBHG. TAN SRI/DATO'/Tuan/Puan hendaklah menukar katalaluan yang diberi semasa pertama kali menggunakan sistem ini dengan".
								  " menekan (klik) butang \"TUKAR KATALALUAN\" di menu login sistem ini. Tuan/Puan dinasihatkan untuk menukar katalaluan setiap".
								  " 3 bulan sebagai langkah keselamatan sistem.<br/><br/>".
								"4) YBHG. TAN SRI/DATO'/Tuan/Puan hendaklah memaklumkan kepada Pentadbir Sistem sekiranya tidak lagi menggunakan SSJP.<br/><br/>".
								"5) SSJP boleh dicapai melalui <b> https://ssjp.moh.gov.my </b> atau melalui Portal KKM.<br/><br/>".
								"6) Sebarang pertanyaan  mengenai sistem ini boleh dikemukakan kepada ssjp@moh.gov.my atau menghubungi pegawai - pegawai berikut.<br/><br/>". 

								  "<table width=302 border=1 align=center>".
                                   /* "<tr>".
                                     "<td width=97><div align=center><strong>Nama</strong></div></td>".
                                     "<td width=89><div align=center><strong>No. Samb.</strong></div></td>".
                                 	
									 "</tr>".*/
								     "<tr>".
                                     "<td><div align=center>Encik. Buhairi Bin Jahilan (0388832950)</div></td>".
                                     
                                     "</tr>". 
								   "</tr>".
                                     "<tr>".
                                   "<td><div align=center>Puan Norliza Binti Razali (0388833239)</div></td>".
                                   //"<td><div align=center>03-88823644</div></td>".
                                    "</tr>".
                                     "<tr>".
                                     "<td><div align=center>Puan  Marzida Binti Hashim(0388833634)</div></td>".
                                    // "<td><div align=center>03-88824769</div></td>".
                                     "</tr>".
                                   "</table>".
								     
								"<br><br>Sekian, terima kasih<br/><br/>" .
								//"<a href=\ ."http://".$_SERVER['HTTP_HOST']."/ssjp/"."admin/daftar/index.php?action=details&app=yes&id=" . $id. "\">" .
								// ."http://".$_SERVER['HTTP_HOST']."/ssjp/"."admin/daftar/index.php?action=details&app=yes&id=" . $id. "</a><br/><br/>" .
								"Yang menjalankan tugas,<br/><br/>" . 
								//"<b>" . $user . "</b>"; asal pada 16 feb 2009
								  "<b>" . "Pentadbir Sistem" . "</b>";
								
								
				//echo $mail->Body;
				$mail->AddAddress($emel2,$nama );
				if($mail->Send()){
					$error = 1;
				}	
				if($error > 0){
					echo "<br><br><br><center>Pendaftaran berjaya . Emel telah dihantar kepada $nama";
				}							
			
			//echo "<br><br><br><center>Rekod telah disimpan.";
			echo "<br><br><br><center><a href=\"index.php?action=list\">kembali semula</a></center>";
			
		//}	
		
		}
/*		
	}else{
		print $qry."<br/>";
		print mysql_error();
		echo "<br><br><br><center>Rekod gagal disimpan.";
	}
}*/
?>