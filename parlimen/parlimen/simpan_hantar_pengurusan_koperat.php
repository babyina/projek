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
	$pengesahan_status2 = $_POST['Pengesahan_Status2'];
	$catatan = $korperat_catatan;
	$agensi = $_POST['Agensi'];
	$date = MysqlDate(date("d/m/Y"));
	
	
	if ($status==3||$status == 5||$status == 7||$status == 10||$status == 21||$status == 22 || $status == 23)
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
	$catatan_semak = explode("+",$catatan_semak);
	
		
	$message = "Sila klik URL untuk maklumat lanjut\n\n$url\n\n";
	
	//----------email ke?
	//$perkara = getInfo("parlimen", $parlimen_id,"perkara");
	//$subject = $nama_sistem." : ".$perkara."\n";
	//$url = $link_parlimen.$parlimen_id; 	
	//$message = "Sila klik URL untuk maklumat lanjut\n\n$url";	
	//-------------------------------------
	
	
	if($pengesahan_status2 == "1"){
		$next_status = "6"; //pengesahan
		$msg2 = "Rekod telah disimpan. ";
		$salinan= explode("+",$salinan);
		$catatan_semak = explode("+",$catatan_semak);
		$qry1 = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan', korperat_catatan = '$catatan_semak',
			korperat_tarikh = '$date' ,status='$next_status'
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
			
			mysql_query($qry1,$conn) or die(mysql_error());
			
			/*$qry = "UPDATE parlimen SET status='$next_status', pengesahan_catatan = '$pengesahan_catatan', korperat_catatan = '$catatan_semak' ,
			pengesahan_nama = '$pengesahan_nama', pengesahan_jawatan = '$pengesahan_jawatan', pengesahan_tarikh='$date', penyemak = '$penyemak'
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	mysql_query($qry,$conn) or die(mysql_error());*/
			
		if($msg = sendSalinanSemakan($conn,$salinan,$catatan_semak,$subject,$message)){
				echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
				echo $msg."</center><br>";		
		}	
				
	}else{ //0
		$next_status = "10"; // pindaan HEK kepada agensi
		$msg2 = "Rekod perlu dipinda semula.";
		$agensi= explode("+",$agensi);
			
			//set semua agensi status_pindaan=1 kecuali agensi yg perlukan pindaan 
			$q = "UPDATE parlimen_agensi SET status_pindaan=1 WHERE parlimen_id = '$parlimen_id' ";
			mysql_query($q,$conn) or die(mysql_error()); 
								
			foreach($agensi as $key)
				{
					$qry3 = "SELECT id FROM parlimen_agensi WHERE parlimen_id = '$parlimen_id' AND agensi_id = '$key'";
					$result = mysql_query($qry3,$conn) or die(mysql_error());
					$row = mysql_fetch_array($result);
					$id2 = $row['id'];
				
					//set status_pindaan=0 untuk pindaan semula
					$qry2 = "UPDATE parlimen_agensi SET catatan = '$catatan',status_pindaan=0 WHERE id = '$id2'";
					mysql_query($qry2,$conn) or die(mysql_error()); ; 
				}
			
			//sending emails to agencies
				
			if($msg = sendToPegawai($conn,$agensi,$subject,$message)){
				echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
				echo $msg."</center><br>";
			}
	}
	
	/*$qry = "UPDATE parlimen SET status='$next_status', pengesahan_catatan = '$pengesahan_catatan', korperat_catatan = '$catatan_semak' ,
			pengesahan_nama = '$pengesahan_nama', pengesahan_jawatan = '$pengesahan_jawatan', pengesahan_tarikh='$date', penyemak = '$penyemak'
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	mysql_query($qry,$conn) or die(mysql_error());*/
	
	$qry1 = "UPDATE parlimen_agensi SET catatan = '$catatan' WHERE parlimen_id = '$parlimen_id'";
	mysql_query($qry1,$conn) or die(mysql_error());
	
	echo "<br><center>".$msg2."</center>";
	echo "<center><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
	
	echo $qry;
	echo $qry1;
?>