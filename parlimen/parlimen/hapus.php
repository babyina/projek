<?php 

$id = $_POST['id'];
//echo $id;
//<script>
//confirm("Adakah anda pasti ingin menghapus rekod ini?");

$qry 	= "DELETE FROM parlimen WHERE id='$id'";
$qry2 	= "DELETE FROM parlimen_agensi WHERE parlimen_id='$id'";
$qry3 	= "DELETE FROM parlimen_lampiran WHERE parlimen_id='$id'";
$qry4 	= "DELETE FROM soalan_lampiran WHERE parlimen_id='$id'";
$qry5	= "DELETE FROM semakan WHERE parlimen_id='$id'";
//echo $qry5;
$result = mysql_query($qry,$conn) or die(mysql_error());
mysql_query($qry2,$conn) or die(mysql_error());
mysql_query($qry3,$conn) or die(mysql_error());
mysql_query($qry4,$conn) or die(mysql_error());
mysql_query($qry5,$conn) or die(mysql_error());

if(isset($result))
	echo "<center><strong><br /><br />Rekod telah dihapus.</strong></center>";
else 
	echo "<center><strong><br /><br /Rekod tidak dapat dihapus.</strong></center>";
