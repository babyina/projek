<?php
//echo "test";
   $namafail = is_array($_POST['nama_fail'])?implode("+",$_POST['nama_fail']):$_POST['nama_fail'];
	//echo $namafail; 
	if (!empty($namafail)){
		//$namafail= explode("+",$namafail);
		//echo $namafail;
		$namafail= explode("+",$namafail);

	   foreach($namafail as $namafail_id){		
		//echo $namafail_id;
		 $namafail_id=mysql_escape_string($namafail_id);
		$sql_3	= "DELETE FROM parlimen_lampiran where nama_fail ='$namafail_id'"; 
				mysql_query($sql_3,$conn) or die(mysql_error());
				
		$image_dir = 'ssjp/parlimen/parlimen/';
	     
    // upload dir
    $destination = $_SERVER['DOCUMENT_ROOT'].$image_dir;
   
    $upload_file = $GLOBALS['destination'].$namafail_id; 
     unlink($upload_file);		
		}
		}
		
?>