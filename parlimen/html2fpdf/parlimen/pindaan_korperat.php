<?php
	session_start();
	
	$parlimen_id = $_POST['parlimen_id'];
	$pengurusan_catatan = $_POST['Pengurusan_Catatan'];
	$pengurusan_nama = $_SESSION['nama'];
	$pengurusan_jawatan = $_SESSION['jawatan'];
	
	$qry = "UPDATE parlimen SET pengurusan_nama='$pengurusan_nama', pengurusan_jawatan = '$pengurusan_jawatan', pengurusan_catatan='$pengurusan_catatan',status = 3 WHERE id='$parlimen_id' LIMIT 1";
	mysql_query($qry,$conn) or die(mysql_error());
	
	echo "notification has been sent to korperat for pindaan";
	//send mail
	echo "<a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a>";
?>