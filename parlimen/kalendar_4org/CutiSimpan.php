<?php

$id = $_GET['id'];
$tarikh = mysqlDate($_POST['tarikh']);
$hari = $_POST['hari'];
$cuti = $_POST['cuti'];

$isNewDoc = ($_GET['action']=='newdocCuti')?true:false;

if($isNewDoc){	
	$qry = "INSERT INTO kal_cuti (tarikh,hari,cuti) VALUES('$tarikh','$hari','$cuti')";
}else{
	$qry = "UPDATE kal_cuti SET tarikh='$tarikh', hari='$hari', cuti='$cuti' WHERE id = '$id' LIMIT 1";
}

mysql_query($qry,$conn) or die(mysql_error());
if($isNewDoc){
	echo "<br><br><br><center>Rekod telah disimpan.";
}else{
	echo "<br><br><br><center>Rekod telah dikemaskini.";
}

if($isNewDoc) $id = mysql_insert_id();
echo "<br><br><br><center><a href=\"index.php?action=detailsCuti&id=".$id."\">kembali semula</a></center>";

//Redirect
$url	= "index.php?action=listCuti&view=bytarikh";
redirect($url);
exit;

?>