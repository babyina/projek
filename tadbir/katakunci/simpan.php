<?php
$id = $_GET['id'];
//if(strlen($id) < 1){ $id = $_POST['id']; }
$kategori = $_POST['kategori'];
$kod = $_POST['kod'];
$butiran = $_POST['butiran'];

//if($password == $password2)
	//echo "Sukses";
//else
 	//echo"<script type=\"text/javascript\">alert(\"Katalaluan anda tidak sepadan. Sila masukkan katalaluan semula di medan Pengesahan Katalaluan.\") 
	/*</script>";*/


$isNewDoc = ($_GET['action']=='newdoc')?true:false;
if($isNewDoc){

	if ($kategori == "Kawasan Parlimen"){ 
		$qry = "INSERT INTO kawasan (nama) VALUES('$butiran')";
	}else
	if ($kategori == "Parti") {
		$qry = "INSERT INTO parti (nama_pendek,nama_panjang) VALUES('$kod','$butiran')";
	}else{ 
	
	$qry = "INSERT INTO konfigurasi (kategori,kod,butiran) VALUES('$kategori','$kod','$butiran')";
	} } 
	else{
	
	if ($kategori == "Kawasan Parlimen"){
		$qry = "UPDATE kawasan SET nama='$butiran' WHERE id = '$id' LIMIT 1";}
	else if ($kategori == "Parti"){
		$qry = "UPDATE parti SET nama_pendek='$kod',nama_panjang='$butiran' WHERE id = '$id' LIMIT 1";}
	else {
		$qry = "UPDATE konfigurasi SET kategori='$kategori',kod='$kod',butiran='$butiran' WHERE id = '$id' LIMIT 1";}	
	}
mysql_query($qry,$conn) or die(mysql_error());


if($isNewDoc){
	echo "<br><br><br><center>Rekod telah disimpan.";
}else{
	
	echo "<br><br><br><center>Rekod telah dikemaskini.";
}

if($isNewDoc) $id = mysql_insert_id();
echo "<br><br><br><center><a href=\"index.php?action=details&id=".$id."&cat=".$kategori."\">kembali semula</a></center>";

?>