<?php
	session_start();
	
	$parlimen_id = $_POST['parlimen_id'];
	$status = $_POST['status'];
	$korperat_nama = $_SESSION['nama'];
	$korperat_jawatan = $_SESSION['jawatan'];
	$korperat_jawapan = addslashes($_POST['Korperat_Jawapan']);
	$korperat_tambahan = addslashes($_POST['Korperat_Tambahan']);
	$korperat_catatan = addslashes($_POST['Korperat_Catatan']);
	$catatan = $korperat_catatan;
	$agensi = $_POST['Agensi'];
	$date = MysqlDate(date("d/m/Y"));
	
	if ($status==3||$status == 5||$status == 7||$status == 10||$status == 21||$status == 22)
	{
	
	$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan', korperat_catatan = '$korperat_catatan',
			korperat_tarikh = '$date', status = '$status' 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	}
	
	
	
	
	
	
	
	
	$parlimen_id = $_POST['parlimen_id'];
	$pengurusan_catatan = addslashes($_POST['Pengurusan_Catatan']);
	$pengurusan_nama = addslashes($_SESSION['nama']);
	$pengurusan_jawatan = $_SESSION['jawatan'];
	$pengurusan_tarikh = $_POST['pengurusan_tarikh'];
	
	$msg = "Rekod telah disimpan.";
	$qry = "UPDATE parlimen SET pengurusan_nama='$pengurusan_nama', pengurusan_jawatan = '$pengurusan_jawatan', pengurusan_catatan='$pengurusan_catatan', pengurusan_tarikh='$pengurusan_tarikh' WHERE id='$parlimen_id' LIMIT 1";
	mysql_query($qry,$conn) or die(mysql_error());
	
	echo "<br><center>".$msg."</center>";
	echo "<center><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
?>