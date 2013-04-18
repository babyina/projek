 <?php
	$parlimen_id = $_POST['parlimen_id'];
	$status = $_POST['status'];
	$korperat_nama = $_SESSION['nama'];
	$korperat_jawatan = $_SESSION['jawatan'];
	$jawapan = $_POST['Jawapan_Final'];
	$catatan = $_POST['Catatan_Final'];
	$korperat_tambahan = $_POST['Korperat_Tambahan'];
	
	$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			jawapan = '$jawapan', korperat_tambahan = '$korperat_tambahan', catatan_final = '$catatan',
			status = 9
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";

	mysql_query($qry,$conn) or die(mysql_error());
	$msg = "Jawapan Akhir telah disimpan.";
	echo $msg;
	echo "<br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a>";
	
?>