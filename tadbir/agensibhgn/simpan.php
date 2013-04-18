<?php
$id = $_GET['id'];
//if(strlen($id) < 1){ $id = $_POST['id']; }
$kategori = $_POST['kategori'];
$nama = $_POST['nama'];
$nama_pendek = $_POST['nama_pendek'];
$tksp=$_POST['tksp'];

//if($password == $password2)
	//echo "Sukses";
//else
 	//echo"<script type=\"text/javascript\">alert(\"Katalaluan anda tidak sepadan. Sila masukkan katalaluan semula di medan Pengesahan Katalaluan.\") 
	/*</script>";*/


$isNewDoc = ($_GET['action']=='newdoc')?true:false;

if($isNewDoc){	
	$qry = "INSERT INTO agensi (kategori,nama,nama_pendek,tksp) VALUES('$kategori','$nama','$nama_pendek','$tksp')";
}else{
	$qry = "UPDATE agensi SET kategori='$kategori', nama='$nama', nama_pendek='$nama_pendek' , tksp='$tksp' WHERE id = '$id' LIMIT 1";
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