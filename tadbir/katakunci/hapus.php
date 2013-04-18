<?php
		
		$id = ($_GET['id'])?$_GET['id']:$_POST['id'];
		$view_k=$_GET['view_k'];
		$cat = $_GET['cat'];
		if($view_k=='byparti' || $cat=='Parti'){
		$qry = "DELETE FROM parti WHERE id = '$id'";
		mysql_query($qry) or die(mysql_error());
		echo "<br /><br /><center>Rekod telah berjaya dihapus.</center>";}
		else if ($view_k=='bykawasan'||$cat=='Kawasan Parlimen'){
		$qry = "DELETE FROM kawasan WHERE id = '$id'";
		mysql_query($qry) or die(mysql_error());
		echo "<br /><br /><center>Rekod telah berjaya dihapus.</center>";}
		
		else{
		$qry = "DELETE FROM konfigurasi WHERE id = '$id'";
		mysql_query($qry) or die(mysql_error());
		echo "<br /><br /><center>Rekod telah berjaya dihapus.</center>";}
?>