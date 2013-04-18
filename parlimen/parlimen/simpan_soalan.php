<?php
session_start();

$current_user=$_SESSION['nama'];
$current_time = date("Y-m-d G:i:s");
$sesi_dewan = $_POST['Sesi'];
$mesyuarat = $_POST['Mesyuarat'];
$penggal = $_POST['Penggal'];
$parlimen = $_POST['Parlimen'];
$tkh_mula_bersidang = mysqlDate($_POST['TkhMulaBersidang']);
$tkh_akhir_bersidang = mysqlDate($_POST['TkhAkhirBersidang']);
$bentuk_soalan = $_POST['BentukSoalan'];
$no_soalan = $_POST['NoSoalan'];
$kawasan_id = $_POST['kawasan_id']; if(empty($kawasan_id)) $kawasan_id = 0;
$negeri = $_POST['negeri_id']; if(empty($negeri)) $negeri = 0;
$ahli_dewan_id = $_POST['ahli_dewan_id'];
$parti_id = $_POST['parti_id'];
$tkh_jawab = mysqlDate($_POST['tkh_jawab']);
$tkh_bentang_jawapan = mysqlDate($_POST['TkhBentang']);
$perkara = mysql_escape_string($_POST['Perkara']);
$soalan = addslashes($_POST['Soalan']);
$agensi = is_array($_POST['Agensi'])?implode("+",$_POST['Agensi']):$_POST['Agensi'];
$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
$status = 1;
$isNewDoc = ($_GET['action']=='newdoc')?true:false;
$id = $_GET['id'];

if(empty($tkh_mula_bersidang))
	$tkh_mula_bersidang="0000-00-00";
if(empty($tkh_akhir_bersidang))
	$tkh_akhir_bersidang="0000-00-00";
if(empty($tkh_jawab))
	$tkh_jawab="0000-00-00";
if(empty($tkh_bentang_jawapan))
	$tkh_bentang_jawapan="0000-00-00";
if(empty($ahli_dewan_id))
	$ahli_dewan_id="0";
if(empty($parti_id))
	$parti_id="0";


if($isNewDoc){	
	$qry = "INSERT INTO parlimen 
			(sesi_dewan,mesyuarat,penggal,parlimen,tkh_mula_bersidang,tkh_akhir_bersidang,
			bentuk_soalan,no_soalan,kawasan_id,negeri,ahli_dewan_id,tkh_bentang_jawapan,perkara,soalan,agensi,parti_id,status,salinan,tkh_jawab,created_by,created_on) 
			VALUES 
			('$sesi_dewan','$mesyuarat','$penggal','$parlimen','$tkh_mula_bersidang','$tkh_akhir_bersidang',
			'$bentuk_soalan','$no_soalan','$kawasan_id','$negeri','$ahli_dewan_id','$tkh_bentang_jawapan','$perkara','$soalan','$agensi','$parti_id','$status','$salinan','$tkh_jawab','$current_user','$current_time')";
		
			mysql_query($qry,$conn) or die(mysql_error());
			
			$id = mysql_insert_id();
			$msg = "<br/><a href=\"index.php?action=details&id=".$id."\">kembali semula</a>";
						
}else{ //edit
	$qry = "UPDATE parlimen SET sesi_dewan = '$sesi_dewan',mesyuarat='$mesyuarat',penggal='$penggal',
			parlimen = '$parlimen',tkh_mula_bersidang = '$tkh_mula_bersidang',tkh_akhir_bersidang = '$tkh_akhir_bersidang',
			bentuk_soalan = '$bentuk_soalan',no_soalan = '$no_soalan',kawasan_id = '$kawasan_id', negeri='$negeri',tkh_jawab = '$tkh_jawab', 
			ahli_dewan_id = '$ahli_dewan_id',tkh_bentang_jawapan = '$tkh_bentang_jawapan',perkara = '$perkara',
			soalan = '$soalan',agensi = '$agensi',parti_id='$parti_id',status= '$status',salinan='$salinan' WHERE id = '$id' LIMIT 1";
		
			mysql_query($qry,$conn) or die(mysql_error());
			
			$msg = "<br/><a href=\"index.php?action=details&id=".$id."\">kembali semula</a>";
}

#if($isNewDoc) $id = mysql_insert_id();
	echo "<center><br>Rekod telah disimpan - draf<br><br>"; 
	echo $msg;
	//echo $agensi;
	
?>
