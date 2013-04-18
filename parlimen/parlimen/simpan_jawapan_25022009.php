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
	$keterangan_tambahan = $_POST['keterangan_tambahan'];
	$penyedia_no_tel_pej = $_POST['penyedia_no_tel_pej'];
	$penyedia_no_hp = $_POST['penyedia_no_hp'];
	$pengesah_no_tel_pej = $_POST['pengesah_no_tel_pej'];
	$pengesah_no_hp = $_POST['pengesah_no_hp'];
	$disemak_oleh = $_POST['disemak_oleh'];
	$penyemak_jawatan = $_POST['penyemak_jawatan'];
	$penyemak_no_tel_pej = $_POST['penyemak_no_tel_pej'];
	$penyemak_no_hp = $_POST['penyemak_no_hp'];
	$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];

	$qry = "UPDATE parlimen_agensi SET agensi_id = '$agensi_id',nama_pegawai = '$nama_pegawai',penyedia_nama = '$penyedia_nama', status = 1,penyedia_jawatan = '$penyedia_jawatan',pengesah_nama = '$pengesah_nama',pengesah_jawatan = '$pengesah_jawatan',	no_telefon = '$no_telefon',jawapan='$jawapan',tambahan='$tambahan',keterangan_tambahan='$keterangan_tambahan',keterangan_tambahan = '$keterangan_tambahan',penyedia_no_tel_pej = '$penyedia_no_tel_pej',	penyedia_no_hp = '$penyedia_no_hp',pengesah_no_tel_pej = '$pengesah_no_tel_pej',pengesah_no_hp = '$pengesah_no_hp',disemak_oleh = '$disemak_oleh',penyemak_jawatan = '$penyemak_jawatan',penyemak_no_tel_pej = '$penyemak_no_tel_pej',penyemak_no_hp = '$penyemak_no_hp'
		WHERE id='$jawapan_id'" ;	
	mysql_query($qry,$conn) or die(mysql_error());
	
	if ($status==22){
	$qry6 = "UPDATE parlimen SET status = 22,salinan = '$salinan' WHERE id='$parlimen_id'";
			mysql_query($qry6,$conn) or die(mysql_error());
	}elseif ($status==21){
	$qry6 = "UPDATE parlimen SET status = 22,salinan = '$salinan' WHERE id='$parlimen_id'";
			mysql_query($qry6,$conn) or die(mysql_error());
			}
		
	/*$perkara = getInfo("parlimen", $parlimen_id,"perkara");
	$subject = $nama_sistem." : ".$perkara;
	$url = $link_parlimen.$parlimen_id; 	
	$message = "Sila klik URL untuk maklumat lanjut\n\n$url";	
	
	
			$salinan= explode("+",$salinan);
			if($msg = sendSalinan($conn,$salinan,$subject,$message)){
				echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br /><br />";
				echo $msg."</center><br>";

			}*/

	//echo $perkara."<br>".$subject."<br>".$url."<br>".$message."<br>".$salinan."<br>".$conn;
	
	echo "<br><center>Rekod telah disimpan";
	echo "<br><br><a href=\"index.php?action=details&id=".$_GET['id']."\">kembali semula</a>";
	
?>