<?php
	session_start();
	
	$pengesahan_status = $_POST['Pengesahan_Status2']; 
	$pengurusan_nama = addslashes($_SESSION['nama']);
	$pengurusan_jawatan = $_SESSION['jawatan'];
	$parlimen_id = $_POST['parlimen_id'];
	$id = $_POST['parlimen_id'];
	$pengurusan_catatan = addslashes($_POST['Pengurusan_Catatan']);
	$pengurusan_tarikh = $_POST['pengurusan_tarikh'];
	$date = MysqlDate(date("d/m/Y"));
	$catatan_semak = is_array($_POST['catatan_semak'])?implode("+",$_POST['catatan_semak']):$_POST['catatan_semak'];
	//$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
	$semaktksp = is_array($_POST['semaktksp'])?implode("+",$_POST['semaktksp']):$_POST['semaktksp'];
	$penyemak = $salinan;
	$perkara = getInfo("parlimen", $parlimen_id,"perkara");
	$no_soalan=getInfo("parlimen", $parlimen_id,"no_soalan");
	$subject = $nama_sistem." : ".$perkara."\n";
	//$link_parlimen="http://192.168.105.173/parlimen/login.php?action=details&id=";
	$url = $link_parlimen.$parlimen_id; 	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut dan tindakan selanjutnya.\n\n$url\n\n\nSekian, terima kasih..";	
	//echo "kepada".$semaktksp;
	$semaktksp= explode("+",$semaktksp);
	//$agensi=array();
	$agensi2=array();
	// $agensi2[] = $_POST['agen'];
	
	$agensi2[]= $_POST['agensi_id'];
	 $findme    = 'ksp';
	// $pos1 = stristr($semaktksp, $findme);
	// $findme = array("KSP");
	 
	 
	if($pengesahan_status==1)
	{
	if (!empty ($semaktksp) )
	{
	  foreach($semaktksp as $semaktksp_id){	
	 //while(list( ,$value) = each($findme)){
	 $pos2= stristr($semaktksp_id,$findme);
	   
	  //if($semaktksp_id==KSP)
	   if ($pos2 != false)
	  {
	  $next_status=13;
	  //echo "hantar ke KSP";
	  $nama_sistem="Draf Soal Jawap Parlimen untuk semakan KSP ";
    $subject = $nama_sistem."No. Soalan: ".$no_soalan." : ".$perkara;
	$url = $link_parlimen.$id; 	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut dan tindakan selanjutnya.\n\n$url\n\n\nSekian, terima kasih..";	
	  
	  
	  $qry = "UPDATE parlimen SET pengurusan_nama='$pengurusan_nama', pengurusan_jawatan = '$pengurusan_jawatan',
			 pengurusan_tarikh='$date', status = '$next_status', penyemak2='$semaktksp_id' WHERE id='$parlimen_id' LIMIT 1";
			 mysql_query($qry,$conn) or die(mysql_error());
	   
	       
	     //$jaw="KSP";
		 $jaw=$findme;
		 
	    	if($msg = sendToKSP($conn,$jaw,$subject,$message)){
			echo "<center><font class=subheader1><br/> Emel telah dihantar kepada </font><br/><br/>";
			echo $msg."</center><br>";
	   
	   
	   
	   } 
	   }
	   
	   
	   else {
	   
	 $next_status=16; 
	// echo "ke mkll/suskmkll";
	 	 // $qry = "UPDATE parlimen SET pengurusan_nama='$pengurusan_nama', pengurusan_jawatan = '$pengurusan_jawatan', pengurusan_catatan='$pengurusan_catatan', asal
		  $qry = "UPDATE parlimen SET pengurusan_nama='$pengurusan_nama', pengurusan_jawatan = '$pengurusan_jawatan', 
			 pengurusan_tarikh='$date', status = '$next_status' WHERE id='$parlimen_id' LIMIT 1";
			 mysql_query($qry,$conn) or die(mysql_error());
			// pengurusan_tarikh='$date', status = '$next_status', penyemak ='$semaktksp_id' WHERE id='$parlimen_id' LIMIT 1";
	 
    $nama_sistem="Soal Jawap Parlimen untuk penyediaan/kelulusan jawapan akhir ";
    $subject = $nama_sistem."No. Soalan: ".$no_soalan." : ".$perkara;
	$url = $link_parlimen.$id; 	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut dan tindakan selanjutnya.\n\n$url\n\n\nSekian, terima kasih..";	
	
	 $cat = $keyword[24];
	if($msg = sendTeksAkhir($conn,$cat,$subject,$message)){
		echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font></br></br></center>"; 
		//echo $msg."</center><br>";
		
		$mailmk=array();
	   $mailmk=$msg ;
	  $mailmk=explode(",",$mailmk); 
	  // echo "ccc". $artemail;
	  foreach($mailmk as $mailmk_id){	
	  echo "<center>".$mailmk_id."</center><br>";
	  
	  }
		
		
	}
		
		$cat = $keyword[23];
	   //echo $cat;
	   if($msg = sendTeksAkhir($conn,$cat,$subject,$message)){
		echo "<center><font class=subheader1><br/> Salinan Emel telah dihantar kepada</font></br></br>";
		echo $msg."</center><br>";
	   }
		  
		 /* if($msg = sendTopttksusk($conn,$subject,$message)) //tak siap lagi
			{
			echo "<center><font class=subheader1><br/>  Salinan Emel telah dihantar kepada </font><br/><br/>";
			echo $msg."</center><br>";
		   } */
		}
	   
	   }
	 }
	}
	else
	{
	 $next_status=12; //hantar kembali ke PPPB"."perlukan maklumat pindaan"
	 //echo "hantar kembali ke PPPB"."perlukan maklumat pindaan";
	 	//foreach($semaktksp as $semaktksp_id){	//add for penyemak 
		
  $qry = "UPDATE parlimen SET pengurusan_nama='$pengurusan_nama', pengurusan_jawatan = '$pengurusan_jawatan', pengurusan_catatan='$pengurusan_catatan',
		 pengurusan_tarikh='$date', status = '$next_status'  WHERE id='$parlimen_id' LIMIT 1";
		//  pengurusan_tarikh='$date', status = '$next_status', penyemak ='$semaktksp_id' WHERE id='$parlimen_id' LIMIT 1";
		 mysql_query($qry,$conn) or die(mysql_error());
	 
	 // } //this the end 
	 
	$nama_sistem="Pindaan Semula Soal Jawap Parlimen -".$pengurusan_jawatan; 
	$subject = $nama_sistem."No. Soalan: ".$no_soalan." : ".$perkara;
	$url = $link_parlimen.$id; 	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut dan tindakan selanjutnya.\n\n$url\n\n\nSekian, terima kasih..";	
    	
	}
	$agensi1=44;
	
	 //sendToPegawai2($conn,$agensi1,$subject,$message)
			$address="ssjp@moh.gov.my";
	    $from = $_SESSION['emel'];		
		$headers = "From: ".$from."\n";	
		if(mail($address,$subject,$message,$headers)){			
			//return   $address_;
			echo "<center><font class=subheader1><br/>Emel telah dihantar kepada Bahagian Perancangan Korporat</font><br/><br/></center>";
			echo "<center>".$address."</center><br>";
		}else
		{
			return false;
	}
	
	
	
   	if (!empty($agensi2)){
	
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
	
	echo "<center><br><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";

?>