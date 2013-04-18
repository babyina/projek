<?php

	function checkLampiran($parlimen_id,$conn)
	{
		$qry3 = "SELECT lampiran from parlimen WHERE parlimen.id = '$parlimen_id' LIMIT 1";
		$result = mysql_query($qry3,$conn) or die(mysql_error());
		if($result==0)
			return "";
		else
		{
			$row = mysql_fetch_row($result);
			return $row['lampiran'];
		}
	}

#-------------------------------------------------------------------------------------------------------------------------------


$sesi_dewan = $_POST['Sesi'];
$perkara = $_POST['Perkara'];
$mesyuarat = $_POST['Mesyuarat'];
$penggal = $_POST['Penggal'];
$parlimen = $_POST['Parlimen'];
$tkh_mula_bersidang = mysqlDate($_POST['TkhMulaBersidang']);
$tkh_akhir_bersidang = mysqlDate($_POST['TkhAkhirBersidang']);
$isOldDoc = ($_GET['action']=='olddoc')?true:false;
$isUpdate = ($_GET['action']=='details')?true:false;
$parlimen_id = $_POST['parlimen_id'];
$jawapan_id = 0;
$status = 0;


//-------------------------------------------------- newdoc -----------------------------------------------------------	
if (!$parlimen_id){
$qry = "INSERT INTO parlimen (sesi_dewan,mesyuarat,penggal,parlimen,tkh_mula_bersidang,tkh_akhir_bersidang,perkara,status) VALUES 
		('$sesi_dewan','$mesyuarat','$penggal','$parlimen','$tkh_mula_bersidang','$tkh_akhir_bersidang','$perkara','$status')";
		mysql_query($qry,$conn) or die(mysql_error());
		$parlimen_id = mysql_insert_id();
		}else{
		
$qry = "UPDATE parlimen SET sesi_dewan = '$sesi_dewan', mesyuarat='$mesyuarat', penggal='$penggal', parlimen='$parlimen', tkh_mula_bersidang='$tkh_mula_bersidang',
			tkh_akhir_bersidang='$tkh_akhir_bersidang',perkara='$perkara', status='$status'
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
			mysql_query($qry,$conn) or die(mysql_error());
	}
		


include("lampiran_parlimen.php");

$msg="Rekod telah disimpan";

echo "<br><center>".$msg;
echo "<br><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";


?>