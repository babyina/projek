<?php
//session_start();
	$no_files = 0;
    $uploaded = array();
	$full_content = array();
	$parlimen_id = $_POST['parlimen_id'];
	$jawapan_id = $_POST['jawapan_id'];
	$agensi_id = $_POST['agensi_id'];
	$nama_pegawai = $_POST['nama_pegawai'];
	$penyedia_nama = $_POST['penyedia_nama'];
	$penyedia_jawatan = $_POST['penyedia_jawatan'];
	$penyedia_no_tel_pej=$_POST['penyedia_no_tel_pej'];
	$penyedia_no_hp=$_POST['penyedia_no_hp'];
	$pengesah_nama = $_POST['pengesah_nama'];
	$pengesah_jawatan = $_POST['pengesah_jawatan']; 
	$pengesah_no_tel_pej = $_POST['pengesah_no_tel_pej']; 
	$pengesah_no_hp = $_POST['pengesah_no_hp'];
	$disemak_oleh = $_POST['disemak_oleh'];
	$penyemak_jawatan = $_POST['penyemak_jawatan'];
	$penyemak_no_tel_pej = $_POST['penyemak_no_tel_pej'];
	$penyemak_no_hp = $_POST['penyemak_no_hp'];
	$jawapan = addslashes($_POST['Jawapan']);
	$tambahan = $_POST['Tambahan'];
	$keterangan_tambahan = $_POST['Keterangan_Tambahan'];
	$status = $_POST['status'];
	$date = date("Y-m-d");
	$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
	$perkara = $_POST['Perkara'];
	$no_soalan = $_POST['NoSoalan'];
	
	
	include("lampiran_parlimen.php");		

//	$qry = "UPDATE parlimen_agensi SET agensi_id = '$agensi_id',nama_pegawai = '$nama_pegawai',penyedia_nama = '$penyedia_nama', status=2,penyedia_jawatan = '$penyedia_jawatan',pengesah_nama = '$pengesah_nama',pengesah_jawatan = '$pengesah_jawatan',no_telefon ='$no_telefon',jawapan='$jawapan',tambahan='$tambahan',keterangan_tambahan='$keterangan_tambahan',lampiran='$lampiran',tkh_terima='$date'
	$qry = "UPDATE parlimen_agensi SET agensi_id = '$agensi_id',nama_pegawai = '$nama_pegawai',penyedia_nama = '$penyedia_nama', status = 1,penyedia_jawatan = '$penyedia_jawatan',
	pengesah_nama = '$pengesah_nama',pengesah_jawatan = '$pengesah_jawatan',	no_telefon = '$no_telefon',jawapan='$jawapan',tambahan='$tambahan',keterangan_tambahan='$keterangan_tambahan',keterangan_tambahan = '$keterangan_tambahan',lampiran='$lampiran',tkh_terima='$date',
	penyedia_no_tel_pej = '$penyedia_no_tel_pej',penyedia_no_hp = '$penyedia_no_hp',
	pengesah_no_tel_pej = '$pengesah_no_tel_pej',pengesah_no_hp = '$pengesah_no_hp',
	disemak_oleh = '$disemak_oleh',penyemak_jawatan = '$penyemak_jawatan',penyemak_no_tel_pej = '$penyemak_no_tel_pej',penyemak_no_hp = '$penyemak_no_hp'
 
	WHERE id='$jawapan_id'";
		
	mysql_query($qry,$conn) or die(mysql_error());
	
	$qry6 = "UPDATE parlimen SET status = 23 WHERE id='$parlimen_id'";
			mysql_query($qry6,$conn) or die(mysql_error());
	
	//check adakah jawapan telah diterima dr semua agensi
	$qry2 = "SELECT id, jawapan, tkh_terima FROM parlimen_agensi WHERE parlimen_id = '$parlimen_id'";
		
	$result = mysql_query($qry2,$conn);
	$count = mysql_num_rows($result);
	
	while($row = mysql_fetch_array($result)){
		if($row['tkh_terima']<>NULL || !empty($row['tkh_terima']))
			$temp[] = $row['tkh_terima'];
	}
	//echo $count.count($temp);
	if($status==10 && (count($temp)==$count))
	{
	
		$qry = "UPDATE parlimen_agensi SET status_pindaan = 1 WHERE id='$jawapan_id'";
		mysql_query($qry,$conn) or die(mysql_error());
		
		$qry3 = "SELECT status_pindaan FROM parlimen_agensi WHERE parlimen_id = '$parlimen_id'";
		$result = mysql_query($qry3,$conn);
		$count2 = mysql_num_rows($result);
	
		while($row = mysql_fetch_array($result)){
			if($row['status_pindaan']==1)
				$temp2[] = $row['status_pindaan'];
		}
		
		if(count($temp2)==$count2) //semua jawapan telah dipinda 
		{
			//update doc status
			
			$qry3 = "UPDATE parlimen SET status = 3 WHERE id='$parlimen_id'";
			mysql_query($qry3,$conn) or die(mysql_error());
		}
	}
	
	else
	{
		if(($status == 23) && count($temp)==$count) //semua jawapan sudah diterima
		{
			//update doc status
			
			$qry3 = "UPDATE parlimen SET status = 3 WHERE id='$parlimen_id'";
			mysql_query($qry3,$conn) or die(mysql_error());
		}
	}
	//if(!empty($error)){
		//echo "<table border=\"1\">";
		//for($i=0; $i<count($error); $i++)
		//{
			//	echo "<tr><td>".$uploaded[$i]."</td><td>".$error[$i]."</td></tr>";
		//}
		//echo "</table>";
	//}

//sending emails to agencies
	$subject = $nama_sistem."No. Soalan: ".$no_soalan." : ".$perkara;
	$url = $link_parlimen.$id; 	
	$message = "Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut dan tindakan selanjutnya.\n\n$url\n\n\nSekian, terima kasih.";	

	if (!empty($salinan)){
		$salinan= explode("+",$salinan);
		if($msg = sendSalinan($conn,$salinan,$subject,$message)){
				echo "<center><font class=subheader1><br/> Salinan emel telah dihantar kepada</font><br/><br/>";
				echo $msg."</center>";
		}
	}
	echo "<br><center>Rekod telah disimpan";
	echo "<br><br><a href=\"index.php?action=details&id=".$_GET['id']."\">kembali semula</a>";
?>
<!-- jamlee edited -->
