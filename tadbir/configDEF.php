<?php
/*  @uses ldap configuration */
//$ldapServer="ldap://192.168.101.145";
$ldapPort = 390;
$ldapServer="ldap://192.168.100.40";
$ldapBase = "O=KWP";
$userldap = "CN=Shahrudin bin Md Nor,OU=Bhg. SMaT,O=KWP";
$pass = "dino5133";

/* @uses mysql configuration */
$host="localhost";
$user="xsspmjm";
$pass="xs\$pm7m";

$db_voffice = 'spmjmspsp';
$conn = mysql_connect($host,$user,$pass) or die(mysql_error());
mysql_select_db($db_voffice,$conn) or die(mysql_error());

/* @uses message yg digunakan */
$delete_record_msg = "<br/><br/><center><div class=\"subheader1\">Rekod Telah Dihapuskan</div></center>";
$update_record_msg = "<br/><br/><center><div class=\"subheader1\">Rekod Telah Disimpan</div></center>";
$save_record_msg = "<br/><br/><center><div class=\"subheader1\">Rekod Telah Disimpan</div></center>";
$acl_denied = "<br/><br/><center><div style=\"border-style:double;border-width:3px;border-color:red;width:350;background-color:red;color:#FFFFFF\">
<br/><b>Capaian tidak membenarkan anda cipta rekod baru <br/>atau edit rekod</b><br/><br/>
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
$link_parlimen = "https://".$_SERVER['HTTP_HOST']."/ssjp/"."login.php?mode=Parlimen&action=details&id=";
$link_kabinet = "https://".$_SERVER['HTTP_HOST']."/ssjp/"."login.php?mode=Kabinet&action=OpenDoc&id=";
$link_memorandum = "https://".$_SERVER['HTTP_HOST']."/ssjp/"."login.php?mode=Memorandum&action=OpenDoc&id=";

/* @users dokumen status */
$doc_status = array();
$doc_status[0] = "Rekod Tertinggal";
$doc_status[1] = "Tahap Penyediaan";
$doc_status[2] = "Untuk Tindakan Jabatan/Agensi (Belum Terima)";
$doc_status[3] = "Untuk Tindakan Jabatan/Agensi";
$doc_status[4] = "Untuk Tindakan DPA";
$doc_status[5] = "Telah Dipersetujui";

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
	$qry = "SELECT $modul FROM pengguna WHERE Id ='$userid'";	
	mysql_select_db($db,$conn) or die(mysql_error());
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	return $row[$modul];
}

function checkACL($userid,$level,$agensi_id,$conn){
	$where = ($agensi_id <> null)?" AND agensi_id = '$agensi_id'":"";
	$qry = "SELECT roles FROM pengguna WHERE id = '$userid'".$where;
	
	$result = mysql_query($qry,$conn);
	if(mysql_num_rows($result)<0) return false;
	$row = mysql_fetch_array($result);			
	$roles = explode("+",$row['roles']);
	foreach($roles as $role){		
		if($role == 0 && $level == -1){ //admin
			return true;
		}elseif($role == 1 && $level == 1){ //kemasukand rekod
			return true;
		}elseif($role == 2 && $level == 2){ //untuk tindakan agensi
			return true;
		}elseif($role == 3 && $level == 3){ //pengurusan
			return true;
		}elseif($role == 4 && $level == 4){
			return true;
		}elseif($role == 5 && $level == 5){
			return true;
		}else{ }		
	}
	return false; //no record match
}

function checkOfficer($userid,$level,$conn){
	$qry = "SELECT roles FROM pengguna WHERE id = '$userid'";
	
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
	return ($status==true)?"highlight":"";
}

?>