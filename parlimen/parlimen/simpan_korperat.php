<?php
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
	
	mysql_query($qry,$conn) or die(mysql_error());
	$msg = "Rekod telah disimpan.";
	echo "<br><center>".$msg;
	echo "<br><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
?>