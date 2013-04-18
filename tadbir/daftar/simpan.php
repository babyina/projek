<?php
require("../../parlimen/phpmailer/class.phpmailer.php");

$valid = "true";
$id_tbl = $_GET['id_tbl'];
//$sistem = $_POST['Sistem'];
$sistem = "Sistem Soal Jawab Parlimen";
$nama = addslashes ($_POST['Nama2']);
$agensi = $_POST['Agensi'];
$inout= $_POST['in_out'];
$jawatan = $_POST['Jawatan'];
$nokp = $_POST['kp1'];
$telefon = $_POST['Code']."-".$_POST['Telefon'];
$hp = $_POST['Pre_num']."-".$_POST['Handphone']; 
//$id_tbl = $_POST['IDnama'];

$emel = $_POST['Emel'];
$emel2 = $_POST['Emel_jab'];
$id_nama = $_POST['IDnama'];
//$cb = implode("+",$_POST['cb']);
$roles_id = is_array($_POST['cb'])?implode("+",$_POST['cb']):$_POST['cb'];

/*if(strlen($_POST['edit']) > 0){
	if($_POST['changePwd']){
		$password = $_POST['Katalaluan'];
	}else{
		$password = $_POST['password'];
	}
}else{
	$password = $_POST['Katalaluan'];
	$password_ori =$_POST['Katalaluan'];
}*/
$password = $_POST['Katalaluan'];
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
//echo $roles; (nilai == 50 || nilai == 53 || nilai == 54)
if ($agensi==50 || $agensi==53 || $agensi==54)
{
$kodldap=2;
}
else
{
$kodldap=1;
}
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

$submit = $_POST['Simpan'];

//if(strlen($_POST['cat']) > 0){ $statusMohon = "LULUS"; }else{ $statusMohon = "PERMOHONAN BARU"; }

$isNewDoc = ($_GET['action']=='newdoc')?true:false;
$errmsg = array();

/*********** HANTAR EMAIL KEPADA PSU ***********/

	
	
		$qry = "UPDATE pengguna SET " .
				"nama='$nama', " .
				"agensi_id='$agensi', " .
				"jawatan='$jawatan', " .
				"nokp='$nokp', " . 
				"telefon='$telefon', " .
				"handphone='$hp', " .
				"emel='$emel', " .
				"emel_jab='$emel2'," .
				//"id='$id_nama', ".
				"kod_ldap='$kodldap',"; 
		if($_POST['changePwd']){		
		  //if ($kodldap==2) {
			$qry .=	"password=MD5('$password'),"; 
		}
		if($inout==1){		
		  if($_POST['Katalaluan']){
		  //if ($kodldap==2) {
			$qry .=	"password=MD5('$password'),"; 
		}
		}
		$qry .=	"roles='$roles_id', " . 
				"modul1='$modul1', " .
				"modul2='$modul2', " .
				"modul3='$modul3', " .
				"modul4='$modul4', " .
				"modul5='$modul5', " .
				"modul6='$modul6' " .
				//"statusMohon='$statusMohon' " .
				"WHERE id_tbl = '$id_tbl'";
				//mysql_query($qry,$conn);
	
        //echo $qry; 
		 
		 if(mysql_query($qry,$conn)){
		 
		 	  $mail = new PHPMailer();
				//$mail->Host = "mye.treasury.gov.my";
				$mail->Host = "zmta1.treasury.gov.my";
				
				//$mail->IsSMTP();  **betulkan disini
				$mail->IsSendmail();  			 
				$mail->From = $userEmel;
				$mail->FromName = "Pentadbir Sistem";
				$mail->WordWrap = 50;
				$mail->IsHTML(true); 
				$mail->Subject = "Pendaftaran Pengguna";
						  
								    $mail->Body   ="YBHG. TAN SRI/DATO'/Tuan/Puan,<br/><br/>";
									
									if($_POST['changePwd']){		
		                             
                                    $mail->Body .="1) Katalaluan YBHG. TAN SRI/DATO'/Tuan/Puan adalah seperti berikut:<br/><br/>".
									"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Katalaluan : $password<br/><br/>";
			                         
		                              } 
									  if($inout==1){		
		                              if($_POST['Katalaluan']){
		 
			                     $mail->Body .="1) Katalaluan YBHG. TAN SRI/DATO'/Tuan/Puan adalah seperti berikut:									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Katalaluan : $password<br/><br/>";
		                               }
									  }
									  
									  if($kodldap==1)
									  {
								    $mail->Body .="1) YBHG. TAN SRI/DATO'/Tuan/Puan hendaklah  menggunakan katalaluan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Katalaluan : $password_ori<br/><br/>";
									   }
								    $mail->Body .="2) SSJP boleh dicapai melalui <b> https://ssjp.moh.gov.my </b> <br/><br/>".
								    "3) Sebarang pertanyaan  mengenai sistem ini boleh dikemukakan kepada ssjp@moh.gov.my atau menghubungi pegawai - pegawai berikut.<br/><br/>".

								  "<table width=302 border=1 align=center>".
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
								
								"Yang menjalankan tugas,<br/><br/>" . 
								//"<b>" . $user . "</b>"; asal pada 16 feb 2009
								 "<b>" . "Pentadbir Sistem" . "</b>";
								
								
				//echo $mail->Body;
				if($kodldap==1) { //start ldap
				$mail->AddAddress($emel2,$nama );
				if($mail->Send()){
					$error = 1;
				}	
				if($error > 0){ 
					echo "<br><br><br><center>Rekod telah disimpan . Emel telah dihantar kepada $nama";
					echo "<br><br><br><center><a href=\"index.php?action=details&id_tbl=" . $id_tbl . "\">kembali semula</a></center>";
				}							
		      
			   }//end ldap
	        else
			{
			$mail->AddAddress($emel2,$nama );
				if($mail->Send()){
					$error = 1;
				}	
				if($error > 0){
			echo "<br><br><br><center>Rekod telah disimpan . Emel telah dihantar kepada $nama";
			echo "<br><br><br><center><a href=\"index.php?action=details&id_tbl=" . $id_tbl . "\">kembali semula</a></center>";
		   }
		   }
		}	
	//}
	else{
		print $qry."<br/>";
		print mysql_error();
		echo "<br><br><br><center>Rekod gagal disimpan."; 
	}
//} 
?>