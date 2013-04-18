 <?php
	$parlimen_id = $_POST['parlimen_id'];
	$status = $_POST['status'];
	$korperat_nama = addslashes($_SESSION['nama']);
	$korperat_jawatan = $_SESSION['jawatan'];
	$jawapan = addslashes($_POST['Jawapan_Final']);
	$catatan = addslashes($_POST['Catatan_Final']);
	$korperat_tambahan = addslashes($_POST['Korperat_Tambahan']); 
	$perkara = getInfo("parlimen", $parlimen_id,"perkara");
	$date = date("Y-m-d");
	$tarikh=date("Y-n-j-G:i:s");
	$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
    $jawapan2 = $_POST['jawapan_'];
	$mak_tamb = $_POST['mak_tamb_'];
	 $agensiakhir=array();
	$agensiakhir[]= $_POST['agensi'];
	$idagensi= $_POST['agensi'];
	$nama_sistem=" SSJP- Jawapan Akhir DiLuluskan ";
	$no_soalan = "No. Soalan: ".$_POST['no_soalan'].". ";
	$subject = $nama_sistem.$no_soalan." : ".$perkara."\n";

	$url = $link_parlimen.$parlimen_id; 	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut\n\n$url";
	
	$qry = "UPDATE parlimen SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
			korperat_jawapan = '$jawapan', korperat_tambahan = '$korperat_tambahan', catatan_final = '$catatan',korperat_tarikh='$date', 
			status = 9
			WHERE parlimen.id = '$parlimen_id' LIMIT 1";
			
			//echo $qry;
			
			//echo "agensiakhir".$agensiakhir;

mysql_query($qry,$conn) or die(mysql_error());
$qry_semak = "SELECT * FROM semakan
			WHERE parlimen_id ='$parlimen_id' AND nama='$korperat_nama' AND status='9'" ;
$result_qry_semak = mysql_query($qry_semak,$conn) or die(mysql_error());
	//echo $qry_semak ;

$totalRows = mysql_num_rows($result_qry_semak);

//echo "<br/>".$totalRows;
if($totalRows>0)
{
$qry8= "UPDATE semakan SET tarikh='$tarikh' WHERE parlimen_id='$parlimen_id' AND nama='$korperat_nama' AND status='9'";
}
else{
$qry8= "INSERT INTO semakan (id,parlimen_id,nama,jawatan,catatan,tarikh,status) VALUES 		('','$parlimen_id','$korperat_nama','$korperat_jawatan','Telah Disemak','$tarikh','9')";
}
//echo $qry8;
mysql_query($qry8,$conn) or die(mysql_error());



  //echo "agensi".$agensiakhir;
	$cat = $keyword[23];
	//echo $cat;
	if($msg = sendTeksAkhir($conn,$cat,$subject,$message)){
		//echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font></br></br></center>";
		//echo $msg."</center><br>";
	
	
		$mailmk=array();
	   $mailmk=$msg ;
	  $mailmk=explode(",",$mailmk); 
	  // echo "ccc". $artemail;
	  foreach($mailmk as $mailmk_id){	
	  //echo "<center>".$mailmk_id."</center><br>";
	  
	  }
	
	
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
	
	
	
	//if($msg = sendToPegawai2($conn,$agensi1,$subject,$message)){
			//echo "<center><font class=subheader1><br/> Emel telah dihantar kepada Bahagian Perancangan Korporat</font><br/><br/></center>";
			//echo $msg."</center><br>";
	
	
		//$artemailksp=array();
	 //  $artemailksp=$msg ;
	 // $artemailksp=explode(",",$artemailksp); 
	  // echo "ccc". $artemail;
	 // foreach($artemailksp as $artemail_idksp){	
	  //echo "<center>".$artemail_idksp."</center><br>";
	  
	  //}
	//}


   	if (!empty($idagensi)){
	
       // echo "<center><font class=subheader1><br/> Emel telah dihantar kepada Pegawai Perhubungan Parlimen Bahagian Berkenaan</font><br/><br/></center>";
			//echo $msg."</center><br>";
			
		if($emelbhg=findemel($conn,$idagensi))
		{
		$address=$emelbhg;
	    $from = $_SESSION['emel'];		
		$headers = "From: ".$from."\n";	
		if(mail($address,$subject,$message,$headers)){			
			//return   $address_;
			echo "<center><font class=subheader1><br/>Emel telah dihantar kepada Pegawai Perhubungan Parlimen Bahagian Berkenaan</font><br/><br/></center>";
			echo "<center>".$address."</center><br>";
		}else
		{
			return false;
    	}
	
	 	
		 }
		 
	}




	/*if (!empty($salinan)){
		$salinan= explode("+",$salinan);
		if($msg = sendSalinan($conn,$salinan,$subject,$message)){
				echo "<center><!--<font class=subheader1><br/> Salinan emel telah dihantar kepada</font>-->";
				echo $msg."<br><br></center>";
		}
	}
	*/
	
//edit pada 27 march 09 atas arahan puan dayang

if($isPengurusan)
{		
$qry15 = "UPDATE parlimen_agensi SET jawapan='$jawapan2' , tambahan='$mak_tamb'	WHERE parlimen_id='$parlimen_id' LIMIT 1";
		//echo $qry15;
	mysql_query($qry15,$conn) or die(mysql_error());
}
	
	$msg = "Jawapan Akhir telah disimpan.";
	echo "<br /><center>".$msg;
	echo "<br /><br /><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
	
?>
<!--jamlee edited-->