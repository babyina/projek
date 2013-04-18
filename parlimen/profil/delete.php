<?php
	if($sys_acl==1){
		$mode	= $_POST['mode'];
		$id		= $_POST['id'];
		switch($mode){
			case "rakyat" : 
				$sql1 = "DELETE FROM ahli_parlimen WHERE id='$id'";
				mysql_query($sql1) or die(mysql_error());
				echo $delete_record_msg;
				break;
			case "negara" : 
				$sql = "DELETE FROM ahli_parlimen WHERE id='$id'";
				mysql_query($sql) or die(mysql_error());
				echo $delete_record_msg;
				break;
		}
	}else{
		echo $acl_denied;
	}
?>