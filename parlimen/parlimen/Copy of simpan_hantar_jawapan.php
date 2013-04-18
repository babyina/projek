<?php
session_start();
	$no_files = 0;
    $uploaded = array();
	$full_content = array();
	$parlimen_id = $_POST['parlimen_id'];
	$id = $_POST['parlimen_id'];
	$jawapan_id = $_POST['jawapan_id'];
	$agensi_id = $_POST['agensi_id'];
	$nama_pegawai = addslashes($_POST['nama_pegawai']);
	$penyedia_nama = addslashes($_POST['penyedia_nama']);
	$penyedia_jawatan = $_POST['penyedia_jawatan'];
	$penyedia_no_tel_pej=$_POST['penyedia_no_tel_pej']; 
	$penyedia_no_hp=$_POST['penyedia_no_hp'];
	$pengesah_nama =addslashes($_POST['pengesah_nama']);
	$pengesah_jawatan = $_POST['pengesah_jawatan']; 
	$pengesah_no_tel_pej = $_POST['pengesah_no_tel_pej']; 
	$pengesah_no_hp = $_POST['pengesah_no_hp'];
	$disemak_oleh = addslashes($_POST['disemak_oleh']);
	$penyemak_jawatan = $_POST['penyemak_jawatan'];
	$penyemak_no_tel_pej = $_POST['penyemak_no_tel_pej'];
	$penyemak_no_hp = $_POST['penyemak_no_hp'];
	$jawapan = addslashes($_POST['Jawapan']);
	$tambahan = $_POST['Tambahan'];
	$keterangan_tambahan = $_POST['Keterangan_Tambahan'];
	$status = $_POST['status'];
	$date = date("Y-m-d");
	//$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
	$restksp = is_array($_POST['tksp'])?implode("+",$_POST['tksp']):$_POST['tksp'];
	$perkara = $_POST['Perkara'];
	$no_soalan = $_POST['NoSoalan'];
	
		$salinan =array();
		$emailpa =array();
		$emailpa2 =array();
		$emailpa[]=$restksp;
	include("lampiran_parlimen.php");		

//	$qry = "UPDATE parlimen_agensi SET agensi_id = '$agensi_id',nama_pegawai = '$nama_pegawai',penyedia_nama = '$penyedia_nama', status=2,penyedia_jawatan = '$penyedia_jawatan',pengesah_nama = '$pengesah_nama',pengesah_jawatan = '$pengesah_jawatan',no_telefon ='$no_telefon',jawapan='$jawapan',tambahan='$tambahan',keterangan_tambahan='$keterangan_tambahan',lampiran='$lampiran',tkh_terima='$date'
	$qry = "UPDATE parlimen_agensi SET agensi_id = '$agensi_id',nama_pegawai = '$nama_pegawai',penyedia_nama = '$penyedia_nama', status = 1,penyedia_jawatan = '$penyedia_jawatan',
	pengesah_nama = '$pengesah_nama',pengesah_jawatan = '$pengesah_jawatan',	no_telefon = '$no_telefon',jawapan='$jawapan',tambahan='$tambahan',keterangan_tambahan='$keterangan_tambahan',keterangan_tambahan = '$keterangan_tambahan',lampiran='$lampiran',tkh_terima='$date',
	penyedia_no_tel_pej = '$penyedia_no_tel_pej',penyedia_no_hp = '$penyedia_no_hp',
	pengesah_no_tel_pej = '$pengesah_no_tel_pej',pengesah_no_hp = '$pengesah_no_hp',
	disemak_oleh = '$disemak_oleh',penyemak_jawatan = '$penyemak_jawatan',penyemak_no_tel_pej = '$penyemak_no_tel_pej',penyemak_no_hp = '$penyemak_no_hp'
 
	WHERE id='$jawapan_id'";
		//$restksp 
	mysql_query($qry,$conn) or die(mysql_error());
	
	//$qry6 = "UPDATE parlimen SET status = 23 WHERE id='$parlimen_id'"; asal
	
	/*if ($status==12)   // pindaaan dari tksp
	{
	
	$qry6 = "UPDATE parlimen SET status = 14  WHERE id='$parlimen_id'";
			mysql_query($qry6,$conn) or die(mysql_error());
	
	
	$qry6_2="select penyemak from parlimen WHERE id='$parlimen_id'";	
	$rst6_2 =mysql_query($qry6_2,$conn);
	 
	 while($rowemel6_2 = mysql_fetch_array($rst6_2)){
	    //$salinan=implode("+",$rowemel['jawatan']);
		$emailpa2[]=$rowemel6_2['penyemak']; 
		$restksp=$rowemel6_2['penyemak']; 
		
       
		
		}
		//$restksp="/d/";
		//test tkp searc start here
	  /*  $word="/D/";
		if (preg_match($word,$restksp)) { 
            echo "Match was found <br />";
           //echo $matches[0];
       }
	 else
	 {
	 echo "tidak jumpa";
	 }
	 */
	  //end here
		
	/*$qry6_1="select jawatan from pengguna where jawatan like 'pa%' and jawatan like '%$restksp%'";	
	$rst6_1 =mysql_query($qry6_1,$conn);
	 //echo $qry6_1;
	 while($rowemel6_1 = mysql_fetch_array($rst6_1)){
	    //$salinan=implode("+",$rowemel['jawatan']);
		$emailpa2[]=$rowemel6_1['jawatan']; 
		
		
		}
	//  bentuk message email lain untuk pindaan
	  //$nama_sistem="Draf Jawapan Parlimen ";
	  
	
	}
	
	else if ($status==15)// pindaan dari ksp
	{
     $nama_sistem="Pindaan Draf Soal Jawap Parlimen ";
    $subject = $nama_sistem."No. Soalan: ".$no_soalan." : ".$perkara;
	$url = $link_parlimen.$id; 	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut dan tindakan selanjutnya.\n\n$url\n\n\nSekian, terima kasih..";	

	$qry6 = "UPDATE parlimen SET status = 17  WHERE id='$parlimen_id'";
			mysql_query($qry6,$conn) or die(mysql_error());
	
	$qryksp="select penyemak2 from parlimen where id='$parlimen_id'";
	$rstone=mysql_query($qryksp,$conn);
	  $rowemel = mysql_fetch_array($rstone);
	  $jaw=$rowemel['penyemak2'];
	   
	   	if($msg = sendToKSP($conn,$jaw,$subject,$message)){
			echo "<center><font class=subheader1><br/> Emel telah dihantar kepada </font><br/><br/>";
			echo $msg."</center><br>";
	   
	   
	   } 
	       
	}
	else if($status==18) //pindaan dari mkll/suskmkll
	{
	$qry6 = "UPDATE parlimen SET status = 19  WHERE id='$parlimen_id'";
			mysql_query($qry6,$conn) or die(mysql_error());
	
	$subject = "SSJP -Pindaan "."No. Soalan: ".$no_soalan." : ".$perkara;
	$url = $link_parlimen.$id; 	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut dan tindakan selanjutnya.\n\n$url\n\n\nSekian, terima kasih.";	
	//$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut.\n\n$url";
	$cat = $keyword[24];
	if($msg = sendTeksAkhir($conn,$cat,$subject,$message)){
		echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font></br></br></center>"; 
		//echo $msg."</center><br>";
		
		$artemailksp=array();
	   $artemailksp=$msg ;
	  $artemailksp=explode(",",$artemailksp); 
	  // echo "ccc". $artemail;
	  foreach($artemailksp as $artemail_idksp){	
	  echo "<center>".$artemail_idksp."</center><br>";
	  
	  }
		
		
	}
	
	
	}
	
	else
	{*/
	$qry6 = "UPDATE parlimen SET status = 4, penyemak='$restksp'  WHERE id='$parlimen_id'";
			mysql_query($qry6,$conn) or die(mysql_error());
			
	$qry6_1="select jawatan from pengguna where jawatan like 'pa%' and jawatan like '%$restksp%'";	
	$rst6_1 =mysql_query($qry6_1,$conn);
	 
	 while($rowemel6_1 = mysql_fetch_array($rst6_1)){
	    //$salinan=implode("+",$rowemel['jawatan']);
		$emailpa[]=$rowemel6_1['jawatan']; 
		
		
		}
	/*}*/
	
	//check adakah jawapan telah diterima dr semua agensi
	$qry2 = "SELECT id, jawapan, tkh_terima FROM parlimen_agensi WHERE parlimen_id = '$parlimen_id'";
		
	$result = mysql_query($qry2,$conn);
	$count = mysql_num_rows($result);
	
	while($row = mysql_fetch_array($result)){
		if($row['tkh_terima']<>NULL || !empty($row['tkh_terima']))
			$temp[] = $row['tkh_terima'];
	}
	//echo $count.count($temp);
	if($status==10 && (count($temp)==$count))
	{
	
		$qry = "UPDATE parlimen_agensi SET status_pindaan = 1 WHERE id='$jawapan_id'";
		mysql_query($qry,$conn) or die(mysql_error());
		
		$qry3 = "SELECT status_pindaan FROM parlimen_agensi WHERE parlimen_id = '$parlimen_id'";
		$result = mysql_query($qry3,$conn);
		$count2 = mysql_num_rows($result);
	
		while($row = mysql_fetch_array($result)){
			if($row['status_pindaan']==1)
				$temp2[] = $row['status_pindaan'];
		}
		
		if(count($temp2)==$count2) //semua jawapan telah dipinda 
		{
			//update doc status
			
			$qry3 = "UPDATE parlimen SET status = 3 WHERE id='$parlimen_id'";
			mysql_query($qry3,$conn) or die(mysql_error());
		}
	}
	
	else
	{
		if(($status == 23) && count($temp)==$count) //semua jawapan sudah diterima
		{
			//update doc status
			
			//$qry3 = "UPDATE parlimen SET status = 3 WHERE id='$parlimen_id'";
			$qry3 = "UPDATE parlimen SET status = 3, WHERE id='$parlimen_id'";
			mysql_query($qry3,$conn) or die(mysql_error());
		}
	}
	//if(!empty($error)){
		//echo "<table border=\"1\">";
		//for($i=0; $i<count($error); $i++)
		//{
			//	echo "<tr><td>".$uploaded[$i]."</td><td>".$error[$i]."</td></tr>";
		//}
		//echo "</table>";
	//}

//sending emails to agencies

    /* if ($status==12 || $status==15 || $status==18 )
	 {
	  $nama_sistem="Pindaan Draf Jawapan Parlimen ";
	 }
	 else  //status=4
	 {*/
    $nama_sistem="Draf Jawapan Parlimen ";
	/*}*/
	//$no_soalan=$_SESSION['no_soalan'];
	//$perkara=$_SESSION['perkara'];
	$subject = $nama_sistem."No. Soalan: ".$no_soalan." : ".$perkara;
	//echo $subject;
	$url = $link_parlimen.$id; 	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut dan tindakan selanjutnya.\n\n$url\n\n\nSekian, terima kasih.";	

     $qryemel="select * from pengguna where agensi_id=44"; // for bcp only
	 $resultemel =mysql_query($qryemel,$conn);
	  $i=0;
	 while($rowemel = mysql_fetch_array($resultemel)){
	    //$salinan=implode("+",$rowemel['jawatan']);
		 $salinan[$i]=$rowemel['jawatan']; 
		
		$i=$i+1;
		}
		
		

	/*if (!empty($emailpa)){  // email tksp and pa 
	$subject = "Draf Jawapan Parlimen  "."No. Soalan: ".$no_soalan." : ".$perkara;
	if($msg = sendSalinanpatksp($conn,$emailpa,$subject,$message)){
				echo "<center><font class=subheader1><br/> Emel telah dihantar kepada".$restksp."dan pa ".$restksp."</font><br/><br/></center>";
				//echo $msg."</center>";
		
	$artemail2=array();
	 $artemail2=$msg ;
	  $artemail2=explode(",",$artemail2); 
	  // echo "ccc". $artemail;
	  foreach($artemail2 as $artemail_id2){	
	  echo "<center>".$artemail_id2."</center><br>";
	  
	  }
		
		
		}
	
	}
			
	if (!empty($emailpa2)){ //email tksp and pa
	$subject = "pindaan draf jawapan telah dihantar  "."No. Soalan: ".$no_soalan." : ".$perkara;
	if($msg = sendSalinanpatksp($conn,$emailpa2,$subject,$message)){
				echo "<center><font class=subheader1><br/> Emel telah dihantar kepada".$restksp."dan pa ".$restksp."</font><br/><br/></center>";
				//echo $msg."</center>";
		
		$artemail3=array();
	   $artemail3=$msg ;
	  $artemail3=explode(",",$artemail3);  
	 
	  foreach($artemail3 as $artemail_id3){	
	  echo "<center>".$artemail_id3."</center><br>";
	  
	  }
									
		}
	
	}
	*/		
			
	/*if (!empty($salinan)){ 
		
		if($msg = sendSalinan($conn,$salinan,$subject,$message)){
				echo "<center><font class=subheader1><br/>Emel telah dihantar kepada Bahagian Perancangan Korperat</font><br/></center><br/>";
				//echo $msg."</center>";
				
		$artemail=array();
	   $artemail=$msg ;
	  $artemail=explode(",",$artemail); 
	  // echo "ccc". $artemail;
	  foreach($artemail as $artemail_id){	
	  echo "<center>".$artemail_id."</center><br>";
	  
	  }
				
		}
	}
	*/
		/*$address="urusetiaparlimen@treasury.gov.my";
	    $from = $_SESSION['emel'];		
		$headers = "From: ".$from."\n";	
		if(mail($address,$subject,$message,$headers)){			
			//return   $address_;
			echo "<center><font class=subheader1><br/>Emel telah dihantar kepada Bahagian Perancangan Korporat</font><br/><br/></center>";
			echo "<center>".$address."</center><br>";
		}else
		{
			return false;
	}*/
	
	echo "<br><center>Rekod telah disimpan";
	echo "<br><br><a href=\"index.php?action=details&id=".$_GET['id']."\">kembali semula</a>";
?>
<!-- jamlee edited -->
