<?php
$id = $_GET['id'];
$mesyuarat = $_POST['Mesyuarat'];
$penggal = $_POST['Penggal'];
$parlimen = $_POST['Parlimen'];
$sesi = $_POST['Sesi'];

$isNewDoc = ($_GET['action']=='newdoc')?true:false;

if($isNewDoc){	
	$qry = "INSERT INTO mesyuarat (id,parlimen,penggal,sesi,mesyuarat) VALUES('$id','$parlimen','$penggal','$sesi','$mesyuarat')";
}else{
	$qry = "UPDATE ahli_parlimen SET parlimen='$parlimen', penggal='$penggal', sesi='$sesi',mesyuarat='$mesyuarat' WHERE id = '$id' LIMIT 1";
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