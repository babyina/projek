<?php
	if($sys_acl==1){
		$mode	= $_POST['mode'];
		$id		= $_POST['id'];
		$pid	= $_POST['pid'];
		switch($mode){
			case "kalCuti" : 
				$sql = "DELETE FROM kal_cuti WHERE id='$id'";
				mysql_query($sql) or die(mysql_error());
				echo $delete_record_msg;
				break;
				
			case "kalMesyuarat" :
				$sql1 = "DELETE FROM kal_mesyuarat WHERE Kal_mesyuarat_id='$id'";
				$sql2 = "DELETE FROM kal_pegawaitugas WHERE Kal_mesyuarat_id='$id'";
				mysql_query($sql1) or die(mysql_error());
				mysql_query($sql2) or die(mysql_error());
				echo $delete_record_msg;
				break;
			
			case "kalLapDewan" : 
				$sql1 = "DELETE FROM kal_lapdwn WHERE Kal_lapdwn_id='$id'";
				$sql2 = "DELETE FROM kal_lapdwn_st WHERE Kal_lapdwn_id='$id'";
				$sql3 = "DELETE FROM kal_lapdwn_sb WHERE Kal_lapdwn_id='$id'";
				$sql4 = "DELETE FROM kal_lapdwn_ib WHERE Kal_lapdwn_id='$id'";
				$sql5 = "DELETE FROM kal_lapdwn_ru WHERE Kal_lapdwn_id='$id'";
				mysql_query($sql1) or die(mysql_error());
				mysql_query($sql2) or die(mysql_error());
				mysql_query($sql3) or die(mysql_error());
				mysql_query($sql4) or die(mysql_error());
				mysql_query($sql5) or die(mysql_error());
				echo $delete_record_msg;
				break;
				
			case "kalLapDewan_sb" : 
				$sql = "DELETE FROM kal_lapdwn_sb WHERE Kal_lapdwn_sb_id='$id'";
				mysql_query($sql) or die(mysql_error());
				echo $delete_record_msg;
				$url = "index.php?action=editLap&id=".$pid;
				redirect($url);
				break;

			case "kalLapDewan_st" : 
				$sql = "DELETE FROM kal_lapdwn_st WHERE Kal_lapdwn_st_id='$id'";
				mysql_query($sql) or die(mysql_error());
				echo $delete_record_msg;
				$url = "index.php?action=editLap&id=".$pid;
				redirect($url);
				break;
				
			case "kalLapDewan_ib" : 
				$sql = "DELETE FROM kal_lapdwn_ib WHERE Kal_lapdwn_ib_id='$id'";
				mysql_query($sql) or die(mysql_error());
				echo $delete_record_msg;
				$url = "index.php?action=editLap&id=".$pid;
				redirect($url);
				break;

			case "kalLapDewan_ru" : 
				$sql = "DELETE FROM kal_lapdwn_ru WHERE Kal_lapdwn_ru_id='$id'";
				mysql_query($sql) or die(mysql_error());
				echo $delete_record_msg;
				$url = "index.php?action=editLap&id=".$pid;
				redirect($url);
				break;
		}
	}else{
		echo $acl_denied;
	}
?>