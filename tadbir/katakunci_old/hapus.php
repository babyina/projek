<?php
		
		$id = ($_GET['id'])?$_GET['id']:$_POST['id'];
		$qry = "DELETE FROM konfigurasi WHERE id = '$id'";
		mysql_query($qry) or die(mysql_error());
		echo "<br /><br /><center>Rekod telah berjaya dihapus.</center>";
?>