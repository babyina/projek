<?php
	session_start();
	
	$parlimen_id = $_POST['parlimen_id'];
	$pengesahan_catatan = $_POST['Pengesahan_Catatan'];
	$pengesahan_nama = $_SESSION['nama'];
	$pengesahan_jawatan = $_SESSION['jawatan'];
	$date = MysqlDate(date("d/m/Y"));
	
	$qry = "UPDATE parlimen SET pengesahan_catatan = '$pengesahan_catatan', 
			pengesahan_nama = '$pengesahan_nama', pengesahan_jawatan = '$pengesahan_jawatan', pengesahan_tarikh= '$date' 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	mysql_query($qry,$conn) or die(mysql_error());
	$msg = "Rekod telah disimpan.";
	echo $msg;
	echo "<br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a>";
	
?>