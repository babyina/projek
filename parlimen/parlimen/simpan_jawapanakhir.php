  <?php
	$parlimen_id = $_POST['parlimen_id'];
	$status = $_POST['status'];
	$korperat_nama = addslashes($_SESSION['nama']);
	$korperat_jawatan = $_SESSION['jawatan'];
	$korperat_jawapan = addslashes($_POST['Jawapan_Final']);
	$catatan = addslashes($_POST['Catatan_Final']);
	$korperat_tambahan = addslashes($_POST['Korperat_Tambahan']); 
	
	$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan', catatan_final = '$catatan'
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	mysql_query($qry,$conn) or die(mysql_error());
	$msg = "Jawapan Akhir telah disimpan.";
	//echo "<br><center>".$msg;
	//echo "<br><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
	echo"<script>alert('Jawapan Akhir telah disimpan');</script>";
?>