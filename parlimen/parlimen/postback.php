<?php
$id = $_GET['id'];
$parlimen_id= $_GET['id'];
$status=25;//hantar soalan balik ke bcp set status =25;
//echo "test hantar balik ke bcp".$id ; 
$soalan_id=$_POST['no_soalan'];
$catatan_pppb=addslashes($_POST['pppb_catatan']);
$nama_pppb=$_SESSION['nama'];
$jawatan_pppb=$_SESSION['jawatan'];
$bhgn=$_POST['bhg'];
$tarikh_pppb=date("Y-n-j-G:i:s");

//echo "catatan".$catatan_pppb;
$qry6 = "UPDATE parlimen SET status = 25, 
catatan_pppb='$catatan_pppb' ,
tarikh_pppb = '$tarikh_pppb', 
nama_pppb = '$nama_pppb',
jawatan_pppb='$jawatan_pppb' WHERE id='$id'";  
//where last sekali sbb maknenye bile suatu keadaan tu berlaku..
mysql_query($qry6,$conn) or die(mysql_error());







$qry7= "INSERT INTO semakan (id,parlimen_id,nama,jawatan,bhg,catatan,tarikh,status) VALUES ('','$parlimen_id','$nama_pppb','$jawatan_pppb','$bhgn','$catatan_pppb','$tarikh_pppb','25')";  
 //echo $qry7;
//where last sekali sbb maknenye bile suatu keadaan tu berlaku..
mysql_query($qry7,$conn) or die(mysql_error());

	$nama_sistem="SSJP -Soalan Dihantar Semula ";
	$perkara = getInfo("parlimen", $parlimen_id,"perkara");
	$subject = $nama_sistem." : No Soalan ".$soalan_id." : ".$perkara."\n";
	$url = $link_parlimen.$parlimen_id; 	
	//$message = "Sila klik URL untuk maklumat lanjut\n\n$url";	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut\n\n$url";


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
			//echo "<center><font class=subheader1><br/>Emel telah dihantar kepada Bahagian Perancangan Korporat</font><br/><br/></center>";
			//echo $msg."</center><br>";
	
		//$artemail4=array();
	   //$artemail4=$msg ;
	  //$artemail4=explode(",",$artemail4); 
	  // echo "ccc". $artemail;
	 // foreach($artemail4 as $artemail_id){	
	  //echo "<center>".$artemail_id."</center><br>";
	  
	 // }
	
	//}

echo "<center><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
			
?>