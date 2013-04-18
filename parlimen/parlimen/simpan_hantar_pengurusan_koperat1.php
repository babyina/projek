<?php session_start();


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

	
	//----------update koperat info---------
	$parlimen_id = $_POST['parlimen_id'];
	$status = $_POST['status'];
	$korperat_nama = $_SESSION['nama'];
	$korperat_jawatan = $_SESSION['jawatan'];
	$korperat_jawapan = addslashes($_POST['Korperat_Jawapan']);
	$korperat_tambahan = addslashes($_POST['Korperat_Tambahan']);
	$korperat_catatan = addslashes($_POST['Korperat_Catatan']);
	$catatan = $korperat_catatan;
	$agensi = $_POST['Agensi'];
	$date = MysqlDate(date("d/m/Y"));
	
	if ($status==3||$status == 5||$status == 7||$status == 10||$status == 21||$status == 22)
	{
	
	$qry1 = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan',
			korperat_tarikh = '$date' 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	}
	mysql_query($qry1,$conn) or die(mysql_error());
	//-----------abis masuk info koperat------

	
	$parlimen_id = $_POST['parlimen_id'];
	$catatan = $_POST['Catatan_Pindaan'];
	$pengesahan_catatan = addslashes($_POST['Pengesahan_Catatan']);
	$pengesahan_status = $_POST['pengesahan_status'];
	$pengesahan_nama = addslashes($_SESSION['nama']);
	$pengesahan_jawatan = $_SESSION['jawatan'];
	$pengesahan_tarikh = $_POST['pengesahan_tarikh'];
	$date = MysqlDate(date("d/m/Y"));
	//echo $pengesahan_status ;
	$catatan_semak = is_array($_POST['catatan_semak'])?implode("+",$_POST['catatan_semak']):$_POST['catatan_semak'];
	$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
	$penyemak = $salinan;
	
	$perkara = getInfo("parlimen", $parlimen_id,"perkara");
	$subject = $nama_sistem." : ".$perkara."\n";
	//$link_parlimen="http://192.168.105.173/parlimen/login.php?action=details&id=";
	$url = $link_parlimen.$parlimen_id; 	
	$message = "Sila klik URL untuk maklumat lanjut\n\n$url";
	
	//----------email ke?
	//$perkara = getInfo("parlimen", $parlimen_id,"perkara");
	//$subject = $nama_sistem." : ".$perkara."\n";
	//$url = $link_parlimen.$parlimen_id; 	
	//$message = "Sila klik URL untuk maklumat lanjut\n\n$url";	
	//-------------------------------------
	
	
	if($pengesahan_status == "2"){
		$next_status = "6"; //pengesahan
		$msg2 = "Rekod telah disimpan. ";
		$salinan= explode("+",$salinan);
		if($msg = sendSalinan($conn,$salinan,$subject,$message)){
				echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
				echo $msg."</center><br>";
				echo $salinan;
		}	
				
	}else{ //0
		$next_status = "10"; // pindaan HEK kepada agensi
		$msg2 = "Rekod perlu dipinda semula.";
		if($msg = sendHEK($conn,"modul1",$subject,$message)){
			echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
			echo $msg."</center><br>";
		}	
	}
	
	$qry = "UPDATE parlimen SET status=$next_status, pengesahan_catatan = '$pengesahan_catatan', korperat_catatan = '$catatan_semak' ,
			pengesahan_nama = '$pengesahan_nama', pengesahan_jawatan = '$pengesahan_jawatan', pengesahan_tarikh='$date', penyemak = '$penyemak'
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	mysql_query($qry,$conn) or die(mysql_error());
	
	$qry1 = "UPDATE parlimen_agensi SET catatan = '$catatan' WHERE parlimen_id = '$parlimen_id'";
	mysql_query($qry1,$conn) or die(mysql_error());
	
	echo "<br><center>".$msg2."</center>";
	echo "<center><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
	
?>