<?php
	session_start();
	
	$parlimen_id = $_POST['parlimen_id'];
	$pengurusan_catatan = $_POST['Pengurusan_Catatan'];
	$pengurusan_nama = $_SESSION['nama'];
	$pengurusan_jawatan = $_SESSION['jawatan'];
	$pengurusan_tarikh = $_POST['pengurusan_tarikh'];
	
	$msg = "Rekod telah disimpan.";
	$qry = "UPDATE parlimen SET pengurusan_nama='$pengurusan_nama', pengurusan_jawatan = '$pengurusan_jawatan', pengurusan_catatan='$pengurusan_catatan', pengurusan_tarikh='$pengurusan_tarikh' WHERE id='$parlimen_id' LIMIT 1";
	mysql_query($qry,$conn) or die(mysql_error());
	
	echo $msg;
	//send mail
	echo "<br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a>";
?>