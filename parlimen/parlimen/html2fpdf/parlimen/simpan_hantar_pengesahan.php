<?php
	session_start();
	
	$parlimen_id = $_POST['parlimen_id'];
	$pengesahan_catatan = $_POST['Pengesahan_Catatan'];
	$pengesahan_status = $_POST['Pengesahan_Status'];
	$pengesahan_nama = $_SESSION['nama'];
	$pengesahan_jawatan = $_SESSION['jawatan'];
	
	if($pengesahan_status == "1"){
		$next_status = "8"; // jawapan akhir HEK after meeting
		$msg = "Rekod telah disimpan.";
		
	}else{
		$next_status = "7"; // pindaan HEK
		$msg = "Rekod perlu dipinda semula.";
	}
	
	$qry = "UPDATE parlimen SET status=$next_status, pengesahan_catatan = '$pengesahan_catatan', 
			pengesahan_nama = '$pengesahan_nama', pengesahan_jawatan = '$pengesahan_jawatan' 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	mysql_query($qry,$conn) or die(mysql_error());
	
	echo $msg;
	echo "<br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a>";
	
?>