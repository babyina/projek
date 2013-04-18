<?php
	$parlimen_id = $_POST['parlimen_id'];
	$status = $_POST['status'];
	$korperat_nama = $_SESSION['nama'];
	$korperat_jawatan = $_SESSION['jawatan'];
	$korperat_jawapan = $_POST['Korperat_Jawapan'];
	$korperat_tambahan = $_POST['Korperat_Tambahan'];
	$korperat_catatan = $_POST['Korperat_Catatan'];
	$catatan = $korperat_catatan;
	$agensi = $_POST['Agensi'];

	if ($status==3)
	{
		if($pengesahan_status == "1"){ //Tidak--tiada pindaan
			$msg = "Rekod telah disimpan.";
		
		}else{  //Ya-- pindaan agensi terpilih
			$msg = "Rekod perlu dipinda semula.";
			
			if(is_array($agensi)){
				foreach($agensi as $key)
				{
				echo $key.$catatan."<br>";
				
				$qry3 = "SELECT id FROM parlimen_agensi WHERE parlimen_id = '$parlimen_id' AND agensi_id = '$key'";
				$result = mysql_query($qry3,$conn) or die(mysql_error());
				$row = mysql_fetch_array($result);
				$id2 = $row['id'];
				echo $id2;
	
				$qry2 = "UPDATE parlimen_agensi SET catatan = '$catatan' WHERE id = $id2";
				mysql_query($qry2,$conn) or die(mysql_error());
				}
			}			
		}
		
	$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan', korperat_catatan = '$korperat_catatan',
			status = '$status' 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	}elseif($status==6){ //utk sahkan after meeting
	$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan',
			status = '$status'
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	}
	
	mysql_query($qry,$conn) or die(mysql_error());
	echo "maklumat korperat telah disimpan ";
	echo "<a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a>";
	

?>