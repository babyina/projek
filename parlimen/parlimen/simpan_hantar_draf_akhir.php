<?php
	session_start();
	 //$agensi2 = $_POST['agen'];
	         $agensi2=array();
		 
	         $agensi2[] =    $_POST['agensip'];
	// echo "agensi".$agensi2;
	 // $agensi_id2 = $_SESSION['agensi_id'];
	$parlimen_id = $_POST['parlimen_id'];
	$soalan_id = $_POST['no_soalan'];
	
	$operasi_tindakan = $_POST['operasi_tindakan'];
	$ksp_tindakan = $_POST['ksp_tindakan'];
	$draf_catatan_dasar = $_POST['draf_catatan_dasar'];
	
	if($draf_catatan_dasar!='')
	{
	$catatan_semakan=$draf_catatan_dasar;
	}
	else
	{
	$catatan_semakan="Telah Disemak";
	}
	
	
	$jawapan = $_POST['jawapan_'];
	$mak_tamb = $_POST['mak_tamb_'];
	$catatan_operasi = addslashes($_POST['catatan_operasi']);  
	//$jawapan_2 = $_POST['jawapan'];
	//$mak_tamb_2 = $_POST['mak_tamb'];
	//echo $ksp_tindakan;
	$akhir_catatan = addslashes($_POST['drafakhirjawapan']);  
	//echo "catatan".$akhir_catatan."<br>";
	//$pengesahan_status = $_POST['Pengesahan_Status'];
	$akhir_nama = addslashes($_SESSION['nama']);
	//echo "nama".$akhir_nama."<br>"; 
	$akhir_jawatan = $_SESSION['jawatan'];
	//echo "jawatan".$akhir_jawatan."<br>";
	$date = MysqlDate(date("d/m/Y"));
	$tarikh=date("Y-n-j-G:i:s");
	//echo "idpar".$parlimen_id."<br>";
	$nama_sistem="SSJP -Pindaan dari".	$akhir_jawatan;
	$perkara = getInfo("parlimen", $parlimen_id,"perkara");
	$no_soalan=getInfo("parlimen", $parlimen_id,"no_soalan");
	$subject = $nama_sistem." : No Soalan ".$soalan_id." : ".$perkara."\n";
	$url = $link_parlimen.$parlimen_id; 	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\Sila klik URL untuk maklumat lanjut\n\n$url";
	
	if($ksp_tindakan==2)
	{
	$next_status = "43";
		$qry = "UPDATE parlimen SET status=$next_status	WHERE parlimen.id = '$parlimen_id' LIMIT 1";
		//echo $qry;
	mysql_query($qry,$conn) or die(mysql_error());
	
	$qry15 = "UPDATE parlimen_agensi SET jawapan='$jawapan' , tambahan='$mak_tamb'	WHERE parlimen_id = '$parlimen_id' LIMIT 1";
		//echo $qry15;"
		echo "<br>".$jawapan2."<br>".$jawapan2;
	mysql_query($qry15,$conn) or die(mysql_error());
	
	
		$qry8= "INSERT INTO semakan (id,parlimen_id,nama,jawatan,catatan,tarikh,status) VALUES 		('','$parlimen_id','$akhir_nama','$akhir_jawatan','$catatan_semakan','$tarikh','12')"; 
		mysql_query($qry8,$conn) or die(mysql_error()); 
		
		//echo $qry8;
		$qry6_1="select jawatan from pengguna where  jawatan like 'KSP'";	
	$rst6_1 =mysql_query($qry6_1,$conn);
	 //echo $qry6_1;
	 while($rowemel6_1 = mysql_fetch_array($rst6_1)){
	    //$salinan=implode("+",$rowemel['jawatan']);
		$emailpa[]=$rowemel6_1['jawatan']; 
		
	 }
		if (!empty($emailpa)){  // email tksp and pa 
		$subject = "Draf Jawapan Parlimen  "."No. Soalan: ".$no_soalan." : ".$perkara;
		if($msg = sendSalinanpatksp($conn,$emailpa,$subject,$message)){
				echo "<center><font class=subheader1><br/> Emel telah dihantar kepada KSP dan pa KSP</font><br/><br/>	</center>";
				//echo $msg."</center>";
		
	$artemail2=array();
	 $artemail2=$msg ;
	  $artemail2=explode(",",$artemail2); 
	  // echo "ccc". $artemail;
	  foreach($artemail2 as $artemail_id2){
	  $artemail_id2=$artemail_id2;
	 
	  
	  }
		 echo "<center>".$artemail_id2."</center><br>";
		
		}
	
	}
		
	}
	
	
	else if($operasi_tindakan==2)
	{
	$next_status = "43";
		$qry = "UPDATE parlimen SET status=$next_status	WHERE parlimen.id = '$parlimen_id' LIMIT 1";
		//echo $qry;
	mysql_query($qry,$conn) or die(mysql_error());
	
	$qry15 = "UPDATE parlimen_agensi SET jawapan='$jawapan' , tambahan='$mak_tamb'	WHERE parlimen_id = '$parlimen_id' LIMIT 1";
		//echo $qry15;"
		echo "<br>".$jawapan2."<br>".$jawapan2;
	mysql_query($qry15,$conn) or die(mysql_error());
	
	
		$qry8= "INSERT INTO semakan (id,parlimen_id,nama,jawatan,catatan,tarikh,status) VALUES 		('','$parlimen_id','$akhir_nama','$akhir_jawatan','$catatan_operasi','$tarikh','12')"; 
		mysql_query($qry8,$conn) or die(mysql_error()); 
		//echo  $qry8;
		//$qry6_1="select jawatan from pengguna where jawatan like 'pa%' and jawatan like '%KSP%'";	
		$qry6_1="select jawatan from pengguna where jawatan like 'KSP'";	
	$rst6_1 =mysql_query($qry6_1,$conn);
	 //echo $qry6_1;
	 while($rowemel6_1 = mysql_fetch_array($rst6_1)){
	    //$salinan=implode("+",$rowemel['jawatan']);
		$emailpa[]=$rowemel6_1['jawatan']; 
		
	 }
		if (!empty($emailpa)){  // email tksp and pa 
		$subject = "Draf Jawapan Parlimen  "."No. Soalan: ".$no_soalan." : ".$perkara;
		if($msg = sendSalinanpatksp($conn,$emailpa,$subject,$message)){
				echo "<center><font class=subheader1><br/> Emel telah dihantar kepada KSP dan pa KSP</font><br/><br/>	</center>";
				//echo $msg."</center>";
		
	$artemail2=array();
	 $artemail2=$msg ;
	  $artemail2=explode(",",$artemail2); 
	  // echo "ccc". $artemail;
	  foreach($artemail2 as $artemail_id2){
	  $artemail_id2=$artemail_id2;
	 
	  
	  }
		 echo "<center>".$artemail_id2."</center><br>";
		
		}
	
	}
	}
	
	else if(!empty($akhir_catatan))
	{
		if($isPengurusan)
		{
		
		$next_status = "12";
		$qry = "UPDATE parlimen SET status=$next_status, korperat_catatan  = '$akhir_catatan', 
			korperat_nama  = '$akhir_nama', korperat_jawatan  = '$akhir_jawatan', korperat_tarikh ='$date' 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
		
		$qry7= "INSERT INTO semakan (id,parlimen_id,nama,jawatan,catatan,tarikh,status) VALUES ('','$parlimen_id','$akhir_nama','$akhir_jawatan','$akhir_catatan','$tarikh','12')";  

//where last sekali sbb maknenye bile suatu keadaan tu berlaku..

//$qry15 = "UPDATE parlimen_agensi SET jawapan='$jawapan' , tambahan='$mak_tamb'	WHERE parlimen_id = '$parlimen_id' LIMIT 1";
		//echo $qry15;//."<br>".$jawapan2."<br>".$mak_tamb2."tst"; 
	//mysql_query($qry15,$conn) or die(mysql_error());
	
		}
		else if($isKSP)
		{
		$next_status = "15";
		$qry = "UPDATE parlimen SET status=$next_status, korperat_catatan  = '$akhir_catatan', 
			korperat_nama  = '$akhir_nama', korperat_jawatan  = '$akhir_jawatan', korperat_tarikh ='$date' 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
			
			$qry7= "INSERT INTO semakan (id,parlimen_id,nama,jawatan,catatan,tarikh,status) VALUES ('','$parlimen_id','$akhir_nama','$akhir_jawatan','$akhir_catatan','$tarikh','15')"; 
		}
		else
		{
		$next_status = "18";
		$qry = "UPDATE parlimen SET status=$next_status, korperat_catatan  = '$akhir_catatan', 
			korperat_nama  = '$akhir_nama', korperat_jawatan  = '$akhir_jawatan', korperat_tarikh ='$date' 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
			$qry7= "INSERT INTO semakan (id,parlimen_id,nama,jawatan,catatan,tarikh,status) VALUES ('','$parlimen_id','$akhir_nama','$akhir_jawatan','$akhir_catatan','$tarikh','18')"; 
		}
		
	//echo $qry7;
	mysql_query($qry,$conn) or die(mysql_error());
	mysql_query($qry7,$conn) or die(mysql_error());
	 foreach ($agensi2 as $node){

		if($emelbhg=findemel($conn,$node)) 
		{
       	$address=$emelbhg;
	    $from = $_SESSION['emel'];		
		$headers = "From: ".$from."\n";	
	   
	    //echo "emel".$emelbhg.$address.$headers.$subject;
		if(mail($address,$subject,$message,$headers)){	
		    echo "<center><font class=subheader1><br/>Emel telah dihantar kepada Pegawai Perhubungan Parlimen Bahagian/Agensi Berkenaan </font><br/><br/></center>";
			echo "<center>".$address."</center><br>";
		
		}
		
		 }
	 
		} 
	
	
		
	
	}
	$address="ssjp@moh.gov.my"; 
	    $from = $_SESSION['emel'];		
		$headers = "From: ".$from."\n";	
		if(mail($address,$subject,$message,$headers)){			
			//return   $address_;
			echo "<center><font class=subheader1><br/>Emel telah dihantar kepada Bahagian Perancangan Korporat</font><br/><br/></center>";
			echo "<center>".$address."</center><br>";
		}
	else
	{
			return false;
	}
	
	
	echo "<center><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
?>