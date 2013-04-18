<?php
$id = $_GET['id'];
$sesi = 2;
$nama = $_POST['nama_yb'];
$pangkat = $_POST['pangkat'];
$negeri = (empty($_POST['Negeri']))? "Tiada":$_POST['Negeri'];
//$status= $_POST['Status'];

$isNewDoc = ($_GET['action']=='newdoc2')?true:false;

if($isNewDoc){	
	$qry = "INSERT INTO ahli_parlimen (sesi_dewan,nama,pangkat,parti_id,kawasan_id,negeri,status) VALUES('$sesi','$nama','$pangkat','0','0','$negeri','1')";
}else{
	$qry = "UPDATE ahli_parlimen SET sesi_dewan='$sesi',nama='$nama',pangkat='$pangkat',negeri='$negeri',status='1' WHERE id = '$id' LIMIT 1";
}

mysql_query($qry,$conn) or die(mysql_error());
if($isNewDoc){
	echo "<br><br><br><center>Rekod telah disimpan.";
}else{
	echo "<br><br><br><center>Rekod telah dikemaskini.";
}

if($isNewDoc) $id = mysql_insert_id();
echo "<br><br><br><center><a href=\"index.php?action=details2&id=".$id."\">kembali semula</a></center>";

?>