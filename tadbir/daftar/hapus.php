<?php

if($_POST['DeleteUser']){		//DELETE kabinet

	$id_tbl= $_GET['id_tbl'];
	$qry = "DELETE FROM pengguna WHERE id_tbl='$id_tbl'";
	mysql_query($qry) or die(mysql_error());

	echo $delete_record_msg; 
}	
	
?>