  <?php
	$parlimen_id = $_POST['parlimen_id'];
	$status = '9';
	$korperat_nama = addslashes($_SESSION['nama']);
	$korperat_jawatan = $_SESSION['jawatan'];
	$korperat_jawapan = addslashes($_POST['Jawapan_Final']);
	$korperat_tambahan = addslashes($_POST['Korperat_Tambahan']); 
	$jns_soalan = $_POST['jns_soalan'];
	$agensi = $_POST['agensi'];
	$date = date("Y-m-d");
	if($jns_soalan =='s1')
	{
	$query="SELECT  tksp from agensi where id='$agensi'";  
 	$result= mysql_query($query);
	$row = mysql_fetch_array($result);
	//echo 	$query;
	$penyemak=$row['tksp'];
//echo $penyemak;
	}
	else {
	$penyemak='KSP';
	}
	$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan', jns_soalan='$jns_soalan',status='$status ',penyemak='$penyemak',korperat_tarikh='$date'
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	mysql_query($qry,$conn) or die(mysql_error());
	$msg = "Jawapan Akhir telah disimpan.";
	//echo $qry ;
	//echo "<br><center>".$msg;
	//echo "<br><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
	echo"<script>alert('Jawapan Akhir telah disimpan');</script>";
?>