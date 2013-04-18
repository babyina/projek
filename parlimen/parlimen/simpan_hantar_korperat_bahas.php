<?php
	
	$no_files = 0;
    $uploaded = array();
	$full_content = array();
	$pengesahan_status = $_POST['pengesahan_status'];
	$main_id = $_POST['bahas_id']; // id sesi_bahas
	$status = $_POST['status'];
	$korperat_nama = addslashes($_SESSION['nama']);
	$korperat_jawatan = $_SESSION['jawatan'];
	$korperat_jawapan = $_POST['Korperat_Jawapan'];
	$korperat_tambahan = $_POST['Korperat_Tambahan'];
	$korperat_catatan = addslashes($_POST['Korperat_Catatan']);
	$catatan = $korperat_catatan;
	$agensi = is_array($_POST['Agensi'])?implode("+",$_POST['Agensi']):$_POST['Agensi'];
	$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
	$penyemak = $salinan;
	$status_bahas = $_POST['status_bahas'];
	$date = MysqlDate(date("d/m/Y"));
	include("lampiran_bahas.php");
	
	$perkara = getInfo("sesi_bahas", $main_id,"tajuk");
	$subject = $nama_sistem." : ".$perkara."\n";
	$url = $link_bahas.$main_id; 	
	$message = "Sila klik URL untuk maklumat lanjut\n\n$url";
	
	if ($status==3)
	{
		//echo $pengesahan_status;
		if($pengesahan_status == "2"){ //Tidak--tiada pindaan
			$next_status = "4";
			$msg2 = "<br /><center>Rekod telah disimpan.<br /><br />";
			
			//sending emails to pengurusan
			
			$salinan= explode("+",$salinan);
			if($msg = sendSalinan($conn,$salinan,$subject,$message)){
					echo "<center><font class=subheader1><br /> Emel telah dihantar kepada</font><br/><br/>";
					echo $msg."</center><br>";
			}
		
		}else{  //Ya-- pindaan agensi terpilih
			$next_status = "10";
			$msg2 = "<br /><center>Rekod ini perlu dipinda semula.<br /><br />";
			
			//put email here
			$selected_agensi= explode("+",$agensi);
			
			//set semua agensi status_pindaan=1 kecuali agensi yg perlukan pindaan 
			$q = "UPDATE bahas_agensi SET status_pindaan=1 WHERE main_id = $main_id";
			mysql_query($q,$conn) or die(mysql_error());
						
			foreach($selected_agensi as $key)//extract bahas_id
			{
				$qry2 = "UPDATE bahas_agensi SET catatan = '$catatan',status_pindaan=0 WHERE main_id = '$main_id' AND agensi_id = '$key'";
				mysql_query($qry2,$conn) or die(mysql_error());

				//sending emails to agencies
				if($msg = sendToPegawai($conn,$selected_agensi,$subject,$message)){
					echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
					echo $msg."</center><br>";
				}			
			} 		
	}	
	$qry = "UPDATE sesi_bahas SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan', korperat_catatan = '$korperat_catatan', korperat_tarikh = '$date',
			status = '$next_status',status_bahas = '$status_bahas',penyemak = '$penyemak'
			WHERE sesi_bahas.id = '$main_id' LIMIT 1";
	//$qry2 = "UPDATE bahas_agensi SET catatan = '$catatan'";
	mysql_query($qry,$conn) or die(mysql_error());
	
		
	}elseif($status==5){ // pindaan pengurusan
	$qry = "UPDATE sesi_bahas SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan',
			status = 4 
			WHERE sesi_bahas.id = '$main_id' LIMIT 1";
			
	if($msg = sendAtasanBahas($conn,$main_id,$subject,$message)){
		echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
		echo $msg."</center><br>";
	}	
	
	$msg2 = "<br /><center>Rekod telah disimpan.<br /><br />";
	
	}elseif($status==7){ // pindaan pengesahan
	$qry = "UPDATE sesi_bahas SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan',
			status = 6 
			WHERE sesi_bahas.id = '$main_id' LIMIT 1";
	
	if($msg = sendAtasanBahas($conn,$main_id,$subject,$message)){
		echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
		echo $msg."</center><br>";
	}	
	
	$msg2 = "<br /><center>Rekod telah disimpan.<br /><br />";
	
	}elseif($status==8){ // utk sahkan after meeting
	$qry = "UPDATE sesi_bahas SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan',
			status = 9
			WHERE sesi_bahas.id = '$main_id' LIMIT 1";
	
	$cat = $keyword[22];
	//echo $cat;
	if($msg = sendTeksAkhir($conn,$cat,$subject,$message)){
		echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
		echo $msg."</center><br>";
	}
			
	$msg2 = "<br /><center>Rekod telah disimpan.<br /><br />";
	}
	
	mysql_query($qry,$conn) or die(mysql_error());
	
	if(!empty($lampiran))
	{
		$lampiran = checkLampiran($main_id,$conn).$lampiran;
		$qry2 = "UPDATE sesi_bahas SET lampiran = '$lampiran' WHERE sesi_bahas.id = '$main_id' LIMIT 1";
		mysql_query($qry2,$conn) or die(mysql_error());
	}
	
	echo "<br><center>".$msg2."</center>";
	echo "<center><a href=\"index.php?action=detailsbahas&id=".$main_id."\">kembali semula</a></center>";
?>