<?php
session_cache_limiter('public');
$id = $_GET['id'];
$sesi = 1;
$nama = $_POST['nama_yb'];
$pangkat = $_POST['pangkat'];
$kawasan_id = $_POST['Kawasan'];
$parti = $_POST['Parti'];// set as integer
//$status= $_POST['Status'];// set as integer

$isNewDoc = ($_GET['action']=='newdoc')?true:false;

if($isNewDoc){	
	$qry = "INSERT INTO ahli_parlimen (sesi_dewan,nama,pangkat,parti_id,kawasan_id,negeri,status) VALUES('$sesi','$nama','$pangkat','$parti','$kawasan_id',' ' ,'1')";
}else{
	$qry = "UPDATE ahli_parlimen SET sesi_dewan='$sesi', nama='$nama', pangkat='$pangkat',kawasan_id='$kawasan_id',parti_id='$parti',status='1'  WHERE id = '$id' LIMIT 1";
}

mysql_query($qry,$conn) or die(mysql_error());
if($isNewDoc){
	echo "<br><br><br><center>Rekod telah disimpan.";
}else{
	echo "<br><br><br><center>Rekod telah dikemaskini.";
}

if($isNewDoc) $id = mysql_insert_id();
echo "<br><br><br><center><a href=\"index.php?action=details&id=".$id."\">kembali semula</a></center>";

?>