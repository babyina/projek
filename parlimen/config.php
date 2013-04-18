<?php
/* @uses mysql configuration */
//$host="172.16.100.13";
$host="localhost";
//$user="xsspmjm";
//$pass="xs\$pm7m";
//$user="ssjp";
$user="root";
//$pass="ssjp2009";
$pass="password";
$home_site_url = "http://10.22.120.193/ssjptest/parlimen/";
//$home_site_url = "https://ssjp.treasury.gov.my";

//$db_voffice = 'par_kab_test';  //database par_kab 
$db_voffice = 'ssjptest';
$conn = mysql_connect($host,$user,$pass) or die(mysql_error());
mysql_select_db($db_voffice,$conn) or die(mysql_error());

//********************* FCKeditor ********************************.//
//$sBasePath = '/parlimen/js/FCKeditor/';
$sBasePath = '../js/FCKeditor/';

/* @uses message yg digunakan */
$delete_record_msg = "<br/><br/><center><div class=\"subheader1\">Rekod Telah Dihapuskan</div>";
$update_record_msg = "<br/><br/><center><div class=\"subheader1\">Rekod Telah Dikemaskini</div>";
$save_record_msg = "<br/><br/><center><div class=\"subheader1\">Rekod Telah Disimpan</div>";
$acl_denied = "<br/><br/><center><div style=\"border-style:double;border-width:3px;border-color:red;width:350;background-color:red;color:#FFFFFF\">
<br/><br/><b>Capaian tidak membenarkan anda cipta rekod baru <br/>atau edit rekod</b><br/><br/>
</div></center>";
$acl_deny_access = "<br/><br/><center><div style=\"border-style:double;border-width:3px;border-color:red;width:350;background-color:red;color:#FFFFFF\">
<br/><b>Capaian Tidak Sah Untuk Modul Ini</b><br/><br/></div></center>";
$record_exist = "<br/><br/><center><div style=\"border-style:double;border-width:3px;border-color:red;width:350;background-color:red;color:#FFFFFF\">".
"<br/><br/><b>Pengguna telah didaftarkan</b><br/><br/></div></center>";

//********************* PDF Settings ********************************.//
$fontName = "Arial";


//***************** MISC ******************************************/
$app_root = "Location:/";
$header_bahas = "Location:/parlimen/index.php?mode=SesiBahas&action=details&id=";
//$link_parlimen = "http://".$_SERVER['HTTP_HOST']."/ssjp/"."login.php?mode=Parlimen&action=details&id=";
//$link_parlimen="http://".$_SERVER['HTTP_HOST']."/ssjp/"."parlimen/login.php?action=details&id=";
$link_parlimen=$home_site_url."/login.php?action=details&id=";

$link_kabinet = "http://".$_SERVER['HTTP_HOST']."/ssjp/"."login.php?mode=Kabinet&action=OpenDoc&id=";
$link_memorandum = "http://".$_SERVER['HTTP_HOST']."/ssjp/"."login.php?mode=Memorandum&action=OpenDoc&id=";

/* @users dokumen status - SOAL JAWAB PARLIMEN*/
$doc_status = array();
$doc_status[0] = "Rekod Imbasan";
$doc_status[1] = "Soalan Baru";
$doc_status[12] = "Pindaan dari TKSP ";
$doc_status[21] = "Tindakan Bhg/Agensi(Belum Diambil)";
$doc_status[22] = "Tindakan Agensi (Telah Dibaca) ";
$doc_status[23] = "Tindakan Agensi (Telah Dihantar)";
$doc_status[25] = "Soalan dihantar semula";
$doc_status[10] = "Tindakan Agensi (Pindaan Semula)";
$doc_status[3] = "Tindakan HEK";
$doc_status[4] = "Tindakan Peringkat TKSP";
$doc_status[5] = "Tindakan HEK (Pindaan Semula)";
$doc_status[6] = "Tindakan Pengesahan";
$doc_status[7] = "Tindakan HEK (Pindaan Semula)";
$doc_status[8] = "Tindakan HEK (Jawapan Akhir)";
$doc_status[9] = "Jawapan Akhir";
$doc_status[13] = "Semakan KSP";
$doc_status[14] = "Pindaan Telah Dihantar ke TKSP";
$doc_status[15] = "Tindakan Bahagian/Agensi(Pindaan Semula Dari KSP)";
$doc_status[16] = "Penyediaan Jawapan Akhir";
$doc_status[17] = "Semakan KSP";
$doc_status[18] = "Tindakan Bahagian/Agensi (Pindaan Semula dari MKII)";
$doc_status[19] = "Penyediaan Jawapan Akhir";
$doc_status[41] = "Penyediaan Jawapan Akhir TKSP";
$doc_status[42] = "Semakan/Penyediaan Jawapan Akhir TKSP";
$doc_status[43] = "Penyediaan Jawapan Akhir KSP";
$doc_status[44] = "Bukan bidang kuasa MOF";
/* @users dokumen status - SESI BAHAS */
$doc_status2 = array();

$doc_status2[1] = "Soalan Baru";
$doc_status2[21] = "Tindakan Agensi";
$doc_status2[22] = "Tindakan Agensi";
$doc_status2[10] = "Tindakan Agensi (Pindaan Semula)";
$doc_status2[3] = "Tindakan HEK";
$doc_status2[4] = "Tindakan Pengurusan";
$doc_status2[5] = "Tindakan HEK(Pindaan Semula)";
$doc_status2[6] = "Tindakan Pengesahan";
$doc_status2[7] = "Tindakan HEK(Pindaan Semula)";
$doc_status2[8] = "Tindakan HEK (Jawapan Akhir)";
$doc_status2[9] = "Jawapan Akhir";
$doc_status2[13] = "Semakan KSP";

include("katakunci.php");

$desc[0] = "";
$desc[1] = "";
$desc[2] = "";
$desc[3] = "";
$desc[4] = "";
$desc[5] = "Jabatan/Agensi/Bahagian";
$desc[6] = "Jenis Pengguna Sistem";
$desc[7] = "";
$desc[8] = "";
$desc[9] = "";
$desc[10] = "Nama Negeri";
$desc[11] = "Parti/Wakil";
$desc[12] = "";
$desc[13] = "";
$desc[14] = "";
$desc[15] = "";
$desc[16] = "-";
$desc[17] = "-";
$desc[18] = "-";

//arkib
$expired_parlimen = "ADDDATE(TkhPengurusan,INTERVAL 90 DAY) < CURDATE()"; //3 bulan selepas jawapan diedit/dihantar oleh pengurusan kpd sub/tksu
$not_expired_parlimen = "(ADDDATE(TkhPengurusan,INTERVAL 90 DAY) >= CURDATE() OR TkhPengurusan IS NULL)";
$expired_kabinet = "ADDDATE(TkhPengurusan,INTERVAL 150 DAY) < CURDATE()"; //5 month selepas disahkan
$not_expired_kabinet = "(TkhPengurusan IS NOT NULL AND ADDDATE(TkhPengurusan,INTERVAL 150 DAY) >= CURDATE() OR TkhPengurusan IS NULL)"; //5 month selepas disahkan
/* @uses function checkmodul */
function checkModul($conn,$db,$modul,$userid){
	//$qry = "SELECT $modul FROM pengguna WHERE Id ='$userid'";	
	$qry = "SELECT $modul FROM pengguna WHERE id = '$userid' or nokp='$userid'";		
	mysql_select_db($db,$conn) or die(mysql_error());
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	return $row[$modul];
}
function checkModulList($conn,$modul,$userid){
	//$qry = "SELECT $modul FROM pengguna WHERE Id ='$userid'";	(id = '$userid' or nokp='$userid')
	$qry = "SELECT $modul FROM pengguna WHERE id = '$userid' or nokp='$userid'";	
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row[$modul]==4)
		return true;
		//return $row[$modul];
	else
		return false;
		//return $row[$modul];
}
function checkACL($userid,$level,$agensi_id,$conn){
	$where = ($agensi_id <> null)?" AND agensi_id = '$agensi_id'":"";
	//$qry = "SELECT roles FROM pengguna WHERE id = '$userid'".$where;
	$qry = "SELECT roles FROM pengguna WHERE id = '$userid' or nokp='$userid'".$where;
	
	$result = mysql_query($qry,$conn);
	if(mysql_num_rows($result)<0) return false;
	$row = mysql_fetch_array($result);			
	$roles = explode("+",$row['roles']);
	foreach($roles as $role){		
		if($role == 0 && $level == -1){ //admin
			return true;
		}elseif($role == 1 && $level == 1){ //admin
			return true;
		}elseif($role == 2 && $level == 2){ //untuk tindakan agensi
			return true;
		}elseif($role == 3 && $level == 3){ //HEK
			return true;
		}elseif($role == 4 && $level == 4){ //pengurusan
			return true;
		}elseif($role == 5 && $level == 5){ //pengesahan
			return true;
		}elseif($role == 6 && $level == 6){ //agensi - pegawai bertugas
			return true;
		}elseif($role == 7 && $level == 7){ //parlimen - pegawai bertugas
			return true;
		}elseif($role == 8 && $level == 8){ //psu - hek
			return true;
		}elseif($role == 9 && $level == 9){ //parlimen - hubung
			return true;
		}elseif($role == 10 && $level == 10){ //jemaah menteri - hubung
			return true;
		}elseif($role == 11 && $level == 11){ //pentadbiran
			return true;
		}
	}
	return false; //no record match
}


function checkModulHEK($conn,$modul,$userid){
	//$qry = "SELECT $modul FROM pengguna WHERE Id ='$userid'";	
	 $qry = "SELECT $modul FROM pengguna WHERE id = '$userid' or nokp='$userid'";	
	
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row[$modul]==1)
		return true;
	else
		return false;
}

function checkOfficer($userid,$level,$conn){
	//$qry = "SELECT roles FROM pengguna WHERE id = '$userid'";
	$qry = "SELECT roles FROM pengguna WHERE id = '$userid' or nokp='$userid'";
	$result = mysql_query($qry,$conn);
	if(mysql_num_rows($result)<0) return false;
	$row = mysql_fetch_array($result);			
	$roles = explode("+",$row['roles']);
	foreach($roles as $role){		
		if($role == 0 && $level == -1){ 
			return true;
		}elseif($role == 1 && $level == 1){ //admin
			return true;
		}elseif($role == 2 && $level == 2){ //untuk tindakan agensi (role=level)
			return true;
		}elseif($role == 3 && $level == 3){ //hek
			$sys_acl = checkModulHEK($conn,"modul1",$userid);
			if($sys_acl)			
				return true;
				
			else
				return true;  
				
		}elseif($role == 4 && $level == 4){ //pengurusan
			return true;
		}elseif($role == 5 && $level == 5){ //pengesahan
			return true;
		}elseif($role == 6 && $level == 6){ //agensi - pegawai bertugas
			return true;
		}elseif($role == 7 && $level == 7){ //parlimen - pegawai bertugas
			return true;
		}elseif($role == 8 && $level == 8){ //psu - hek
			return true;
		}elseif($role == 9 && $level == 9){ //parlimen - hubung
			return true;
		}elseif($role == 10 && $level == 10){ //jemaah menteri - hubung
			return true;
		}elseif($role == 11 && $level == 11){ //pentadbiran
			return true;
		}elseif($role == 12 && $level == 12){ //kwp
			return true;
		}		
	}
	return false; //no record match
}


function highlight($status){	
	//echo "fffhhhh".$status;
	return ($status==true)?"highlight":"";
	//echo "fffhhhh".$status;
	
}
//add for agensi id

   $qry_agensi= "SELECT jawatan,emel,agensi_id FROM pengguna WHERE id = '".$_SESSION['userid']."' or nokp='".$_SESSION['userid']."'";		
	mysql_select_db($db_voffice,$conn) or die(mysql_error());
	$result_agensi = mysql_query($qry_agensi,$conn) or die(mysql_error());
	$row_agensi = mysql_fetch_array($result_agensi);
	$_SESSION['agensi_id'] = $row_agensi['agensi_id'];
	$_SESSION['jawatan'] =$row_agensi['jawatan'];
	$_SESSION['emel'] = $row_agensi['emel'];
	//echo "idxx".$row_agensi['agensi_id'].$qry_agensi;
	//return $row[$modul];
//}
function displaybutiran($kodbutiran,$conn){
		$qry = "SELECT nama FROM kawasan  WHERE id= '$kodbutiran'";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		
		while($row = mysql_fetch_array($result)){
		$butiran_1= $row['nama'];
		
	}
	return $butiran_1;
}

?>
