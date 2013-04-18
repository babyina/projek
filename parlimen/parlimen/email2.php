<?php

include("index.php");


	$qry2 = "SELECT * FROM pengguna WHERE agensi_id='1'";
	$res = mysql_query($qry2,$conn) or die(mysql_error());
	//$row = mysql_fetch_array($result);
	$count = mysql_num_rows($res);
	//echo $count;
	while($rows = mysql_fetch_array($res))
	{
		//$emel[$i] = $row['emel'];$i++;
		//echo $rows["emel"];
	}
	
	$agensi = array('1','2');
	$subject = "SUBJEK\n";
	$link_parlimen="http://192.168.105.173/parlimen/login.php?action=details&id=";
	$url = $link_parlimen.$id; 	
	//echo $url;
	$message = "Sila klik URL maklumat lanjut\n\n$url";	
	//$msg = sendToPegawai($conn,$agensi,$subject,$message);
		//	echo "<center><font class=subheader1><br/> Dan Dihantar Untuk Dijawab</font><br/><br/>";
		//	echo $msg."</center>";
	$i = 0;
	//foreach ($agensi as $agensi_id ){
	//$temp = explode("+",$node);
		$qry2 = "SELECT * FROM pengguna WHERE agensi_id='0'";
		$res = mysql_query($qry2,$conn) or die(mysql_error());
		//$row = mysql_fetch_array($result);
		while($row = mysql_fetch_array($res))
		{
			$emel[$i] = $row['emel'];$i++;
			//echo $row['emel'];
		}
	//}	
		//if($emel = getEmail($conn,$agensi_id)){
			$email = implode(",",$emel);
		//}
			echo "<br>".$email;
		
		$id = 467;
		$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND parlimen_id=$id";
		$res = mysql_query($qry,$conn) or die(mysql_error());
		$row4 = mysql_fetch_array($res);
			$nama_fail = $row4['nama_fail']; 
			$path = "../parlimen/lampiran/$nama_fail";
			//echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br>";

		
?>
				