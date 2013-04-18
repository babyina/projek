<?php
session_start();

$no_files = 0;
$uploaded = array();
$current_user=$_SESSION['nama'];
$current_time = date("Y-n-j-G:i:s");
$sesi_dewan = $_POST['Sesi'];
$mesyuarat = $_POST['Mesyuarat'];
$penggal = $_POST['Penggal'];
$parlimen = $_POST['Parlimen'];
$tkh_mula_bersidang = mysqlDate($_POST['TkhMulaBersidang']);
$tkh_akhir_bersidang = mysqlDate($_POST['TkhAkhirBersidang']);
$bentuk_soalan = $_POST['BentukSoalan'];
$no_soalan = $_POST['NoSoalan'];
$kawasan_id = $_POST['kawasan_id']; if(empty($kawasan_id)) $kawasan_id = 0;
$negeri = $_POST['negeri_id']; if(empty($negeri)) $negeri = 0;
$ahli_dewan_id = $_POST['ahli_dewan_id'];
$parti_id = $_POST['parti_id']; if(empty($parti_id)) $parti_id = 0;
$tkh_jawab = mysqlDate($_POST['tkh_jawab']);
$tkh_bentang_jawapan = mysqlDate($_POST['TkhBentang']);
$perkara = mysql_escape_string($_POST['Perkara']);
$soalan = addslashes($_POST['Soalan']);
$agensi = is_array($_POST['Agensi'])?implode("+",$_POST['Agensi']):$_POST['Agensi'];
//$agensi2=$_POST['Agensi'];
$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
//echo $salinan;
$draf = ($_POST['SubmitDraf'])?1:2;
$submit = ($_POST['SubmitSoalan'])?1:2; 
$isNewDoc = ($_GET['action']=='newdoc')?true:false;
$isUpdate = ($_GET['action']=='details')?true:false;
$action=$_GET['action'];
$id = $_GET['id'];
$status = 21;
//$drpd=$_SESSION['emel'];	
$nama_sistem="Sistem Soal Jawab Parlimen";
	$subject = $nama_sistem." No. Soalan: ".$no_soalan." : ".$perkara;
	$url = $link_parlimen.$id; 	
	//$message = "Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut\n\n$url\n\nSekian,terima kasih.";	
	$message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut\n\n$url";
	
//check for  tkh_bentang_jawapan

if(empty($tkh_bentang_jawapan))
{

$tkh_bentang_jawapan=date('Y');
$tkh_bentang_jawapan=$tkh_bentang_jawapan."-00-00";
}

if($bentuk_soalan=="Bertulis")
{

$tkh_bentang_jawapan=date('Y');
$tkh_bentang_jawapan=$tkh_bentang_jawapan."-00-00"; 
}



//--------------------------------------------tksp action----------------------------------//
$qrytksp= mysql_query("select tksp from agensi where id='$agensi'",$conn) or die(mysql_error());
$row = mysql_fetch_array($qrytksp);   
$tkspone=$row['tksp'];
//-------------------------------------------------- newdoc -----------------------------------------------------------	
if($action=='newdoc'){
	$qry = "INSERT INTO parlimen (sesi_dewan,mesyuarat,penggal,parlimen,tkh_mula_bersidang,tkh_akhir_bersidang,
			bentuk_soalan,no_soalan,kawasan_id,negeri,ahli_dewan_id,tkh_bentang_jawapan,perkara,soalan,agensi,parti_id,status,penyemak,salinan,tkh_jawab,created_by,created_on) VALUES 
			('$sesi_dewan','$mesyuarat','$penggal','$parlimen','$tkh_mula_bersidang','$tkh_akhir_bersidang',
			'$bentuk_soalan','$no_soalan','$kawasan_id','$negeri','$ahli_dewan_id','$tkh_bentang_jawapan','$perkara','$soalan','$agensi','$parti_id','$status','$tkspone','$salinan','$tkh_jawab','$current_user','$current_time')";
	mysql_query($qry,$conn) or die(mysql_error());
	$id = mysql_insert_id();
	$parlimen_id = $id;
	include("lampiran_soalan.php");

	$msg2 = "<br/><a href=\"index.php?action=details&id=".$id."\">kembali semula</a>";	
	
	//------- create new record for every agensi in table parlimen_agensi ------------------
	//AGENSI = PPJ, Labuan, PL, Bahagian2 di KWP
	
	$agensi= explode("+",$agensi);

	foreach($agensi as $agensi_id){		
		$query = "SELECT nama_pegawai FROM parlimen_agensi WHERE parlimen_id='$id' AND agensi_id='$agensi_id'";
		$result = mysql_query($query,$conn) or die(mysql_error());
		
		if(mysql_num_rows($result)==0){
			$qry = "INSERT INTO parlimen_agensi (agensi_id,parlimen_id) VALUES ('$agensi_id','$id')";			
			mysql_query($qry,$conn) or die(mysql_error());
		//echo $qry ;
		}
	}
	
	//jamlee - edited

	//sending emails to agencies

	
	//sending emails to hek
	

	//jamlee - edited

/* RIZAL KOMEN	*/

	$msg2 = "<br/><a href=\"index.php?action=details&id=".$id."\">kembali semula</a>";	
		
//------------------------------------------- update ----------------------------------------------------------------	
				
}else if($action=='details'){ //edit
   //echo "update sini";
	$qry = "UPDATE parlimen SET sesi_dewan = '$sesi_dewan',mesyuarat='$mesyuarat',penggal='$penggal',
			parlimen = '$parlimen',tkh_mula_bersidang = '$tkh_mula_bersidang',tkh_akhir_bersidang = '$tkh_akhir_bersidang',
			bentuk_soalan = '$bentuk_soalan',no_soalan = '$no_soalan',kawasan_id = '$kawasan_id',negeri = '$negeri', tkh_jawab = '$tkh_jawab', 
			ahli_dewan_id = '$ahli_dewan_id',tkh_bentang_jawapan = '$tkh_bentang_jawapan',perkara = '$perkara',
			soalan = '$soalan',agensi = '$agensi',parti_id='$parti_id',status= '$status',penyemak = '$tkspone', salinan='$salinan' WHERE id = '$id' LIMIT 1";

	mysql_query($qry,$conn) or die(mysql_error());
	
	$parlimen_id = $id;
	include("lampiran_soalan.php");			
	$agensi= explode("+",$agensi);
	
	//check wether agensi existed - avoid redundancy
	foreach($agensi as $agensi_id){	
		//27012011$query = "SELECT * FROM parlimen_agensi WHERE parlimen_id='$id' AND agensi_id='$agensi_id'";
		$query = "SELECT * FROM parlimen_agensi WHERE parlimen_id='$id'";
		$result = mysql_query($query,$conn) or die(mysql_error());	
		
		if(mysql_num_rows($result)==0){
			$qry = "INSERT INTO parlimen_agensi (agensi_id,parlimen_id) VALUES ('$agensi_id','$id')"; //asal pada 18 jan 2010	
			//$qry="UPDATE parlimen_agensi  set agensi_id='$agensi_id' where parlimen_id='$id'"; 
			mysql_query($qry,$conn) or die(mysql_error());
		//echo $qry;
		}
		else {
		$qry="UPDATE parlimen_agensi  set agensi_id='$agensi_id' where parlimen_id='$id'"; 
		mysql_query($qry,$conn) or die(mysql_error());
		//echo $qry;
		}
	}
	
	
	
	$msg2 = "<br/><a href=\"index.php?action=details&id=".$id."\">kembali semula</a>";
}

 if(!empty($agensi))
 {
 
    
    $url = $link_parlimen.$parlimen_id; 	
	 $message = "Y.Bhg Tan Sri/Datuk/Dato'/Tuan/Puan,\n\nSila klik URL untuk maklumat lanjut\n\n$url";
	  foreach ($agensi as $node){

		if($emelbhg=findemel($conn,$node))
		{
		$address=$emelbhg;
	    $from = $_SESSION['emel'];		
		$headers = "From: ".$from."\n";	
		if(mail($address,$subject,$message,$headers)){			
			//return   $address_;
			echo "<center><font class=subheader1><br/>Emel telah dihantar kepada </font><br/><br/></center>";
			echo "<center>".$address."</center><br>";
			//echo "sss".$agensi2;
		}else
		{
			return false;
    	}
	
	 	
		 }
		
		} 
}

if($submit==1)
{
	echo "<center><br>Rekod telah disimpan<br>";  
	echo $msg2."</center><br>";
}
?>