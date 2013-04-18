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
	$no_files = 0;
    $uploaded = array();
	$full_content = array();
	$jawapan_id = 0;
	$pengesahan_status = $_POST['pengesahan_status'];
	$parlimen_id = $_POST['parlimen_id'];
	$status = $_POST['status'];
	$korperat_nama = $_SESSION['nama'];
	$korperat_jawatan = $_SESSION['jawatan'];
	$korperat_jawapan = addslashes($_POST['Korperat_Jawapan']);
	$korperat_tambahan = addslashes($_POST['Korperat_Tambahan']);
	$korperat_catatan = addslashes($_POST['Korperat_Catatan']);
	$catatan = $korperat_catatan;
	$catatan_semak = is_array($_POST['catatan_semak'])?implode("+",$_POST['catatan_semak']):$_POST['catatan_semak'];
	$agensi = is_array($_POST['Agensi'])?implode("+",$_POST['Agensi']):$_POST['Agensi'];
	$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
	$penyemak = $salinan;
	//echo $salinan;
	$date = MysqlDate(date("d/m/Y"));
	include("lampiran_parlimen.php");
	
	$perkara = getInfo("parlimen", $parlimen_id,"perkara");
	$subject = $nama_sistem." : ".$perkara;
	$url = $link_parlimen.$parlimen_id; 	
	$message = "Sila klik URL untuk maklumat lanjut\n\n$url";	
	
	
	if ($status==3 ||$status==22 || $status == 23)
	{
		if($pengesahan_status == "2"){ //Tidak--tiada pindaan
			$next_status = "4";
			$msg2 = "Rekod telah disimpan.";
		
			//sending emails to pengurusan
			//echo $salinan;
			$salinan= explode("+",$salinan);
			if($msg = sendSalinan($conn,$salinan,$subject,$message)){
				echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br /><br />";
				echo $msg."</center><br>";

			}	
		
		}else{  //Ya-- pindaan agensi terpilih
			$next_status = "10";
			$msg2 = "Rekod perlu dipinda semula";
			$agensi= explode("+",$agensi);
			
			//set semua agensi status_pindaan=1 kecuali agensi yg perlukan pindaan 
			$q = "UPDATE parlimen_agensi SET status_pindaan=1 WHERE parlimen_id = $parlimen_id";
			mysql_query($q,$conn) or die(mysql_error()); 
								
			foreach($agensi as $key)
				{
					$qry3 = "SELECT id FROM parlimen_agensi WHERE parlimen_id = '$parlimen_id' AND agensi_id = '$key'";
					$result = mysql_query($qry3,$conn) or die(mysql_error());
					$row = mysql_fetch_array($result);
					$id2 = $row['id'];
				
					//set status_pindaan=0 untuk pindaan semula
					$qry2 = "UPDATE parlimen_agensi SET catatan = '$catatan',status_pindaan=0 WHERE id = $id2";
					mysql_query($qry2,$conn) or die(mysql_error()); ; 
				}
			
			//sending emails to agencies
				
			if($msg = sendToPegawai($conn,$agensi,$subject,$message)){
				echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
				echo $msg."</center><br>";
			}
		}			
	
	
		$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan', korperat_catatan = '$catatan_semak', korperat_tarikh = '$date',
			status = '$next_status',penyemak = '$penyemak'
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
		
	}elseif($status==5){ // pindaan pengurusan
		$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
				korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan',
				status = 4
				WHERE parlimen.id = '$parlimen_id' LIMIT 1";
		
		if($msg = sendAtasan($conn,$parlimen_id,$subject,$message)){
			echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
			echo $msg."</center><br>";
		}
				
	$msg2 = "Rekod telah disimpan.";
			
	}elseif($status==7){ // pindaan pengesahan
		$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
				korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan',
				status = 6
				WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
		if($msg = sendAtasan($conn,$parlimen_id,$subject,$message)){
			echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
			echo $msg."</center><br>";
		}	
		$msg2 = "Rekod telah disimpan.";	
	}
	
	mysql_query($qry,$conn) or die(mysql_error());
	
	if(!empty($lampiran))
	{
		$lampiran = checkLampiran($parlimen_id,$conn).$lampiran;
		$qry2 = "UPDATE parlimen SET lampiran = '$lampiran' WHERE parlimen.id = '$parlimen_id' LIMIT 1";
		mysql_query($qry2,$conn) or die(mysql_error());
	}
	
	echo "<br><center>".$msg2;
	echo "<br><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
?>