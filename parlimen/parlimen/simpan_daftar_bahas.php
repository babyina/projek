
<?php
	
$sesi_dewan = $_POST['Sesi'];
$mesyuarat = $_POST['Mesyuarat'];
$penggal = $_POST['Penggal'];
$parlimen = $_POST['Parlimen'];
$tkh_mula_bersidang = mysqlDate($_POST['TkhMulaBersidang']);
$tkh_akhir_bersidang = mysqlDate($_POST['TkhAkhirBersidang']);
$tajuk = $_POST['Tajuk'];
$agensi = is_array($_POST['Agensi'])?implode("+",$_POST['Agensi']):$_POST['Agensi'];
$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
//$lampiran
$draf = ($_POST['SubmitDraf'])?1:2;
$submit = ($_POST['SubmitSoalan'])?1:2; 
$isNewDoc = ($_GET['action']=='newdoc')?true:false;
$isUpdate = ($_GET['action']=='details')?true:false;
$id = $_GET['id'];
$status = 21;

//-------------------------------------------------- newdoc -----------------------------------------------------------	
if($isNewDoc){	
	$qry = "INSERT INTO parlimen (sesi_dewan,mesyuarat,penggal,parlimen,tkh_mula_bersidang,tkh_akhir_bersidang,
			bentuk_soalan,no_soalan,kawasan_id,ahli_dewan_id,tkh_bentang_jawapan,perkara,soalan,agensi,parti_id,status,salinan,tkh_jawab) VALUES 
			('$sesi_dewan','$mesyuarat','$penggal','$parlimen','$tkh_mula_bersidang','$tkh_akhir_bersidang',
			'$bentuk_soalan','$no_soalan','$kawasan_id','$ahli_dewan_id','$tkh_bentang_jawapan','$perkara','$soalan','$agensi','$parti_id','$status','$salinan','$tkh_jawab')";
	
	mysql_query($qry,$conn) or die(mysql_error());
	$id = mysql_insert_id();
		
          //------- create new record for every agensi in table parlimen_agensi ------------------
		
	$agensi= explode("+",$agensi);
	
	if(is_array($agensi)){
		foreach($agensi as $agensi_id){		
			$qry = "INSERT INTO parlimen_agensi (agensi_id,parlimen_id) VALUES ('$agensi_id','$id')";			
			mysql_query($qry,$conn) or die(mysql_error());
		}
	}else{
		$qry = "INSERT INTO parlimen_agensi (agensi_id,parlimen_id) VALUES ('$agensi_id,'$id')";		
		mysql_query($qry,$conn) or die(mysql_error());
	}		
	$msg = "<br/><a href=\"index.php?action=details&id=".$id."\">kembali semula</a>";
		
//------------------------------------------- update ----------------------------------------------------------------	
				
}elseif($isUpdate){ //edit
	$qry = "UPDATE parlimen SET sesi_dewan = '$sesi_dewan',mesyuarat='$mesyuarat',penggal='$penggal',
			parlimen = '$parlimen',tkh_mula_bersidang = '$tkh_mula_bersidang',tkh_akhir_bersidang = '$tkh_akhir_bersidang',
			bentuk_soalan = '$bentuk_soalan',no_soalan = '$no_soalan',kawasan_id = '$kawasan_id', tkh_jawab = '$tkh_jawab', 
			ahli_dewan_id = '$ahli_dewan_id',tkh_bentang_jawapan = '$tkh_bentang_jawapan',perkara = '$perkara',
			soalan = '$soalan',agensi = '$agensi',parti_id='$parti_id',status= '$status', salinan='$salinan' WHERE id = '$id' LIMIT 1";

	mysql_query($qry,$conn) or die(mysql_error());
				
	$agensi= explode("+",$agensi);
	
	if(is_array($agensi)){
		foreach($agensi as $agensi_id){		
		#echo "<br>".$agensi_id;
			$qry = "INSERT INTO parlimen_agensi (agensi_id,parlimen_id) VALUES ('$agensi_id','$id')";			
			mysql_query($qry,$conn) or die(mysql_error());
		}
		$subject = "SUBJEK\n";
		//$link_parlimen="http://localhost/login.php?action=details&id=";
		$link_parlimen="http://192.168.105.173/parlimen/login.php?action=details&id=";
		$url = $link_parlimen.$id; 	
		//echo $url;
		$message = "Sila klik URL maklumat lanjut\n\n$url";	
		if($msg = sendToPegawai($conn,$_POST['Agensi'],$subject,$message)){
				echo "<center><font class=subheader1><br/> Dan Dihantar Untuk Dijawab</font><br/><br/>";
				echo $msg."</center>";
		}			
	}else{
		$qry = "INSERT INTO parlimen_agensi (agensi_id,parlimen_id) VALUES ('$agensi_id','$id')";		
		mysql_query($qry,$conn) or die(mysql_error());
	}		
	$msg = "<br/><a href=\"index.php?action=details&id=".$id."\">kembali semula</a>";
}

if($submit==1)
{
	echo "Rekod telah dihantar";
	echo $msg;
}
?>