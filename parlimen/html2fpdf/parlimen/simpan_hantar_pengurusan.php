<?php
	session_start();
	
	$pengesahan_status = $_POST['Pengesahan_Status'];
	$pengurusan_nama = $_SESSION['nama'];
	$pengurusan_jawatan = $_SESSION['jawatan'];
	$parlimen_id = $_POST['parlimen_id'];
	$pengurusan_catatan = $_POST['Pengurusan_Catatan'];
	$pengurusan_tarikh = $_POST['pengurusan_tarikh'];
	$date = MysqlDate(date("d/m/Y"));
	
	if($pengesahan_status == "1"){
		$next_status = "6"; //pengesahan
		$msg = "Rekod telah disimpan.";
		
	}else{
		$next_status = "5"; //pindaan HEK
		$msg = "Rekod perlu dipinda semula.";
	}
	
	$qry = "UPDATE parlimen SET pengurusan_nama='$pengurusan_nama', pengurusan_jawatan = '$pengurusan_jawatan', pengurusan_catatan='$pengurusan_catatan', pengurusan_tarikh='$date', status = '$next_status' WHERE id='$parlimen_id' LIMIT 1";
	mysql_query($qry,$conn) or die(mysql_error());
	
	echo $msg;
	//send mail
	echo "<br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a>";
?>