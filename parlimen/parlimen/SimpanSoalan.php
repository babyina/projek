<?php
	session_start();
	 //$agensi2 = $_POST['agen'];
	        
	// echo "agensi".$agensi2;
	 // $agensi_id2 = $_SESSION['agensi_id'];
	$parlimen_id = $_POST['parlimen_id'];
	$kodKem = $_POST['kodKem'];
	$catatan_semakan = addslashes($_POST['catatan_kementerian']);  
	//$catatan_semakan="Soalan tidak berkaitan, diluar bidang kuasa MOF";
	$akhir_nama = addslashes($_SESSION['nama']);
	//echo "nama".$akhir_nama."<br>"; 
	$akhir_jawatan = $_SESSION['jawatan'];
	//echo "jawatan".$akhir_jawatan."<br>";
	$date = MysqlDate(date("d/m/Y"));
	$tarikh=date("Y-n-j-G:i:s");
	
	$qry = "UPDATE parlimen SET status='44'	WHERE parlimen.id = '$parlimen_id' LIMIT 1";
		//echo $qry."<br/>";
	mysql_query($qry,$conn) or die(mysql_error());
	
		$qry8= "INSERT INTO semakan (id,parlimen_id,nama,jawatan,bhg,catatan,tarikh,status) VALUES 		('','$parlimen_id','$akhir_nama','$akhir_jawatan','$kodKem','$catatan_semakan','$tarikh','44')"; 
		mysql_query($qry8,$conn) or die(mysql_error()); 
		
		//echo $qry8;
	
	echo "<center><br>Maklumat soalan telah dikemaskini</center><br/>";
	echo "<center><br><a href=\"index.php?action=details&id=".$parlimen_id."\">kembali semula</a></center>";
?>