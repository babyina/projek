<?php
$sesi_dewan = $_POST['Sesi'];
$mesyuarat = $_POST['Mesyuarat'];
$penggal = $_POST['Penggal'];
$parlimen = $_POST['Parlimen'];
$tkh_mula_bersidang = mysqlDate($_POST['TkhMulaBersidang']);
$tkh_akhir_bersidang = mysqlDate($_POST['TkhAkhirBersidang']);
$bentuk_soalan = $_POST['BentukSoalan'];
$no_soalan = $_POST['NoSoalan'];
$kawasan_id = $_POST['kawasan_id'];
$ahli_dewan_id = $_POST['ahli_dewan_id'];
$parti_id = $_POST['parti_id'];
$tkh_bentang_jawapan = mysqlDate($_POST['TkhBentang']);
$perkara = $_POST['Perkara'];
$soalan = $_POST['Soalan'];
$agensi = is_array($_POST['Agensi'])?implode("+",$_POST['Agensi']):$_POST['Agensi'];
$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
$status = ($_POST['SubmitDraf'])?1:2;
$isNewDoc = ($_GET['action']=='newdoc')?true:false;
$id = $_GET['id'];

if($isNewDoc){	
	$qry = "INSERT INTO parlimen (sesi_dewan,mesyuarat,penggal,parlimen,tkh_mula_bersidang,tkh_akhir_bersidang,
			bentuk_soalan,no_soalan,kawasan_id,ahli_dewan_id,tkh_bentang_jawapan,perkara,soalan,agensi,parti_id,status,salinan) VALUES 
			('$sesi_dewan','$mesyuarat','$penggal','$parlimen','$tkh_mula_bersidang','$tkh_akhir_bersidang',
			'$bentuk_soalan','$no_soalan','$kawasan_id','$ahli_dewan_id','$tkh_bentang_jawapan','$perkara','$soalan','$agensi','$part_id','$status','$salinan')";
		
			mysql_query($qry,$conn) or die(mysql_error());
			
			$id = mysql_insert_id();
			$msg = "<br/><a href=\"index.php?action=details&id=".$id."\">kembali semula</a>";
						
}else{ //edit
	$qry = "UPDATE parlimen SET sesi_dewan = '$sesi_dewan',mesyuarat='$mesyuarat',penggal='$penggal',
			parlimen = '$parlimen',tkh_mula_bersidang = '$tkh_mula_bersidang',tkh_akhir_bersidang = '$tkh_akhir_bersidang',
			bentuk_soalan = '$bentuk_soalan',no_soalan = '$no_soalan',kawasan_id = '$kawasan_id',
			ahli_dewan_id = '$ahli_dewan_id',tkh_bentang_jawapan = '$tkh_bentang_jawapan',perkara = '$perkara',
			soalan = '$soalan',agensi = '$agensi',parti_id='$parti_id',status= '$status',salinan='$salinan' WHERE id = '$id' LIMIT 1";
		
			mysql_query($qry,$conn) or die(mysql_error());
			
			$msg = "<br/><a href=\"index.php?action=details&id=".$id."\">kembali semula</a>";
}

#if($isNewDoc) $id = mysql_insert_id();
	echo "Rekod telah disimpan - draf";
	echo $msg;
?>
