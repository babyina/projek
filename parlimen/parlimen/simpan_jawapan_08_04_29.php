 <?php
	$parlimen_id = $_POST['parlimen_id'];
	$jawapan_id = $_POST['jawapan_id'];
	$agensi_id = $_POST['agensi_id'];
	$nama_pegawai = $_POST['nama_pegawai'];
//	$no_telefon = $_POST['no_telefon'];
	$penyedia_nama = $_POST['penyedia_nama'];
	$penyedia_jawatan = $_POST['penyedia_jawatan'];
	$pengesah_nama = $_POST['pengesah_nama'];
	$pengesah_jawatan = $_POST['pengesah_jawatan']; 
	$jawapan = addslashes($_POST['Jawapan']);
	$tambahan = $_POST['Tambahan'];
	$keterangan_tambahan = $_POST['Keterangan_Tambahan'];
	
	$qry = "UPDATE parlimen_agensi SET agensi_id = '$agensi_id',nama_pegawai = '$nama_pegawai',penyedia_nama = '$penyedia_nama',
		penyedia_jawatan = '$penyedia_jawatan',pengesah_nama = '$pengesah_nama',pengesah_jawatan = '$pengesah_jawatan',
		no_telefon = '$no_telefon',jawapan='$jawapan',tambahan='$tambahan',keterangan_tambahan='$keterangan_tambahan'
		WHERE id='$jawapan_id'" ;	
	mysql_query($qry,$conn) or die(mysql_error());
	
	
	echo "<br><center>Rekod telah disimpan";
	echo "<br><br><a href=\"index.php?action=details&id=".$_GET['id']."\">kembali semula</a>";
	
?>