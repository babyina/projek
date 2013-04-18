<?php
   	
	$no_files = 0;
    $uploaded = array();
	$full_content = array();
	$parlimen_id = $_POST['parlimen_id'];
	$jawapan_id = $_POST['jawapan_id'];
	$agensi_id = $_POST['agensi_id'];
	$nama_pegawai = $_POST['nama_pegawai'];
	$penyedia_nama = $_POST['penyedia_nama'];
	$penyedia_jawatan = $_POST['penyedia_jawatan'];
	$pengesah_nama = $_POST['pengesah_nama'];
	$pengesah_jawatan = $_POST['pengesah_jawatan']; 
	$jawapan = addslashes($_POST['Jawapan']);
	$tambahan = $_POST['Tambahan'];
	$keterangan_tambahan = $_POST['Keterangan_Tambahan'];
	$status = $_POST['status'];
	$date = date("Y-m-d");

	include("lampiran_parlimen.php");		

	$qry = "UPDATE parlimen_agensi SET agensi_id = '$agensi_id',nama_pegawai = '$nama_pegawai',penyedia_nama = '$penyedia_nama',
		penyedia_jawatan = '$penyedia_jawatan',pengesah_nama = '$pengesah_nama',pengesah_jawatan = '$pengesah_jawatan',
		no_telefon = '$no_telefon',jawapan='$jawapan',tambahan='$tambahan',keterangan_tambahan='$keterangan_tambahan',lampiran='$lampiran',tkh_terima='$date' 
		WHERE id='$jawapan_id'";
		
	mysql_query($qry,$conn) or die(mysql_error());
	
	//check adakah jawapan telah diterima dr semua agensi
	$qry2 = "SELECT id, jawapan FROM parlimen_agensi WHERE parlimen_id = '$parlimen_id'";
		
	$result = mysql_query($qry2,$conn);
	$count = mysql_num_rows($result);
	
	while($row = mysql_fetch_array($result)){
		if($row['jawapan']<>NULL || !empty($row['jawapan']))
			$temp[] = $row['jawapan'];
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
		if(count($temp)==$count) //semua jawapan sudah diterima
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
	
	echo "<br><center>Rekod telah disimpan";
	echo "<br><br><a href=\"index.php?action=details&id=".$_GET['id']."\">kembali semula</a>";
?>