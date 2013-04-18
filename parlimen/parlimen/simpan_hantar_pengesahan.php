<?php
	session_start();
	$agensi2=array();
	 $agensi2[] = $_POST['agen'];
	$no_soalan=$_POST['no_soalan'];
	  //$agensi = $_POST['agen'];
	 // $agensi_id2 = $_SESSION['agensi_id'];
	$parlimen_id = $_POST['parlimen_id'];
	$pengesahan_catatan = addslashes($_POST['Pengesahan_Catatan']);  
	$pengesahan_status = $_POST['Pengesahan_Status'];
	$pengesahan_nama = addslashes($_SESSION['nama']);
	$pengesahan_jawatan = $_SESSION['jawatan'];
	$date = MysqlDate(date("d/m/Y"));
	//echo $pengesahan_status ;
	$nama_sistem="ssjp -pengesahan jawapan akhir ";
	$perkara = getInfo("parlimen", $parlimen_id,"perkara");
	$no_soalan=getInfo("parlimen", $parlimen_id,"no_soalan");
	$subject = $nama_sistem."No soalan : ".$no_soalan." ".$perkara."\n";
	$url = $link_parlimen.$parlimen_id; 	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut\n\n$url";	
	
	if(empty ($pengesahan_catatan))
	{
	$next_status = "16";
	$qry = "UPDATE parlimen SET status=$next_status, 
			pengesahan_nama = '$pengesahan_nama', pengesahan_jawatan = '$pengesahan_jawatan',penyemak2='$pengesahan_jawatan', pengesahan_tarikh='$date' 
			WHERE parlimen.id = '$parlimen_id' LIMIT 1"; 
	mysql_query($qry,$conn) or die(mysql_error());
	/*
	$nama_sistem="Draf  Soal Jawap Parlimen";
	$subject = $nama_sistem."No. Soalan: ".$no_soalan." : ".$perkara;
	$url = $link_parlimen.$id; 	
	$message = "Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut dan tindakan selanjutnya.\n\n$url\n\n\nSekian, terima kasih..";	
    */
	//echo "agen".$agen.$agensi_id2;
	//$tempdrafakhir=array("MK II","SUSK TMK II");
	$cat = $keyword[24];
	if($msg = sendTeksAkhir($conn,$cat,$subject,$message)){
		echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font></br></br></center>";
		//echo $msg."</center><br>";
		
		
		$artemailmk=array();
	   $artemailmk=$msg ;
	  $artemailmk=explode(",",$artemailmk); 
	  // echo "ccc". $artemail;
	  foreach($artemailmk as $artemail_id){	
	  echo "<center>".$artemail_id."</center><br>";
	  
	  }
		
	}
	
	$cat = $keyword[23];
	//echo $cat;
	if($msg = sendTeksAkhir($conn,$cat,$subject,$message)){
		echo "<center><font class=subheader1><br/> Salinan  Emel telah dihantar kepada</font></br></br></center>";
		//echo $msg."</center><br>";
		
		
		$artemailmk=array();
	   $artemailmk=$msg ;
	  $artemailmk=explode(",",$artemailmk); 
	  // echo "ccc". $artemail;
	  foreach($artemailmk as $artemail_id){	
	  echo "<center>".$artemail_id."</center><br>";
	  
	  }
		
		
		
	}
	
	
	
	
	mysql_query($qry,$conn) or die(mysql_error());
	
	}
	if(!empty ($pengesahan_catatan)) //pindaan ke pppb"No soalan : ".$no_soalan
	{
	$subject = "draf jawapan ssjp pindaan semula "."No Soalan  : ".$no_soalan." ".$perkara."\n";
	$next_status = "15";
	$qry = "UPDATE parlimen SET status=$next_status, pengesahan_catatan = '$pengesahan_catatan', 
			pengesahan_nama = '$pengesahan_nama', pengesahan_jawatan = '$pengesahan_jawatan', pengesahan_tarikh='$date',
			 penyemak2='$pengesahan_jawatan' WHERE parlimen.id = '$parlimen_id' LIMIT 1";
	
	mysql_query($qry,$conn) or die(mysql_error());
	
		
	
	} 
	
	
	
	if (!empty($agensi2))
	
	{
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
	
	
	
		$agensi1=44;
		
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
		
		
		
	
	
	
	
	echo "<center><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
   //	*/// habis sini
?>