<?php
//**************************************************************************************************************************
//Jana Kalendar Persidangan
//Dalam satu persidangan ada titah agong (satu hari), dewan rakyat dan diikuti dewan negara.
//Pada kalendar yg dah digenerate, user boleh isytihar cuti atau tambah hari dewan rakyat/negara. 
//Hari tambahan dewan rakyat boleh overlap dengan dewan negara

//Explaination : 
//ADA DUA PART : 
//	A) NEW DOC (Algorithm) :
//		1. Masukkan entry kalendar dalam kal_mesyuarat utk dapatkan id (satu kalendar satu id)
//		2. Masukkan entry-entry 4 hari selama tempoh bersidang (id child, tarikh tugas, agensi, sesi)
//		3. setPetugas => setkan petugas berdasarkan giliran utk id kalendar nih, plabuan btugas ptg rabu dan khamis pagi
//				Isnin => pagi=kwp,dbkl; ptg=kwp,ppjaya
//				Selasa => pagi=kwp,dbkl; ptg=kwp,ppjaya
//				Rabu => pagi=kwp,dbkl; ptg=kwp,plabuan
//				Khamis => pagi=kwp,plabuan; ptg=kwp,ppjaya
//
//	B) UPDATE DOC
//**************************************************************************************************************************






//Field
$id			= $_GET['id'];
$penggal 	= $_POST['penggal'];
$parlimen 	= $_POST['parlimen'];
$mesyuarat 	= $_POST['mesyuarat'];
$sesi		= $_POST['sesi'];
$tarikhMula	= MysqlDate($_POST['tarikhMula']);
$tarikhAkhir= MysqlDate($_POST['tarikhAkhir']);

$newdocKal 	= ($_GET['action']=='newdocKal')?true:false;

//NEW
if($newdocKal){
	$qry = "INSERT INTO kal_mesyuarat (Parlimen,Penggal,Sesi,Mesyuarat,TarikhMula,TarikhAkhir) 
			VALUES('$parlimen','$penggal','$sesi','$mesyuarat','$tarikhMula','$tarikhAkhir')";
	mysql_query($qry,$conn) or die('kalsimpan.php = '.mysql_error());

	$id	 = mysql_insert_id();
	setCalendar($id, $tarikhMula, $tarikhAkhir);	
}

//UPDATE
else{
	$qry = "UPDATE kal_mesyuarat SET 
			Parlimen='$parlimen', 
			Penggal='$penggal', 
			Sesi='$sesi', 
			Mesyuarat='$mesyuarat', 
			TarikhMula='$tarikhMula', 
			TarikhAkhir='$tarikhAkhir'
			WHERE Kal_mesyuarat_id = '$id' LIMIT 1";
	$msg = "<center>Jadual Pegawai Bertugas telah dikemaskini</center>";
	mysql_query($qry,$conn) or die('kalsimpan.php = '.mysql_error());
}


echo "<center><br><br><a href=\"index.php?action=detailsKal&id=".$id."\">kembali semula</a></center>";
//Redirect
$url	= "index.php?action=detailsKal&id=".$id;
redirect($url);
//exit;









function setCalendar($id, $tarikhMula, $tarikhAkhir){
//untuk compute jadual bertugas semasa create record

	$tkh	= tarikhAvailable($tarikhMula, $tarikhAkhir);  //dapat array tarikh business day. except jumaat, sabtu, ahad dan cuti
	foreach($tkh as $tkhTugas){
		if(checkCuti($tkhTugas)){ //Entry sekiranya tarikh ini = cuti
			$qryTugas	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi) 
							VALUES ('$id', '$tkhTugas', 'CUTI', 'CUTI')";
			mysql_query($qryTugas) or die(mysql_error());
		}
		//Entry selain daripada hari cuti
		else{
			if($tkhTugas==$tarikhMula){ //setkan entry utk hari pertama = titah agong
				$qryTugas1	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi) 
								VALUES ('$id', '$tkhTugas', 'KWP', 'PAGI')";
				$qryTugas2	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi) 
								VALUES ('$id', '$tkhTugas', 'DBKL', 'PAGI')";
				$qryTugas3	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi) 
								VALUES ('$id', '$tkhTugas', 'TIADA SIDANG PADA WAKTU PETANG', 'PETANG')";
				$qryTugas4	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi) 
								VALUES ('$id', '$tkhTugas', 'TIADA SIDANG PADA WAKTU PETANG', 'PETANG')";
			}
			else{
				//PAGI
				$qryTugas1	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi) 
								VALUES ('$id', '$tkhTugas', 'KWP', 'PAGI')";
				$qryTugas2	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi) 
								VALUES ('$id', '$tkhTugas', 'DBKL', 'PAGI')";
				//PERBADANAN LABUAN Bertugas hari rabu petang dan khamis pagi
				if(hari($tkhTugas)=='Thu'){
					$qryTugas2	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi) 
									VALUES ('$id', '$tkhTugas', 'PERBADANAN LABUAN', 'PAGI')";
				}
				
				//PETANG
				$qryTugas3	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi) 
								VALUES ('$id', '$tkhTugas', 'KWP', 'PETANG')";
				$qryTugas4	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi) 
								VALUES ('$id', '$tkhTugas', 'PERBADANAN PUTRAJAYA', 'PETANG')";
				//PERBADANAN LABUAN Bertugas hari rabu petang dan khamis pagi
				if(hari($tkhTugas)=='Wed'){ 
					$qryTugas4	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi) 
									VALUES ('$id', '$tkhTugas', 'PERBADANAN LABUAN', 'PETANG')";
				}
			}
			mysql_query($qryTugas1) or die(mysql_error());
			mysql_query($qryTugas2) or die(mysql_error());
			mysql_query($qryTugas3) or die(mysql_error());
			mysql_query($qryTugas4) or die(mysql_error());
		}
	}
	
	//Automate nama petugas by giliran
	setPetugas('DBKL',$id);
	setPetugas('KWP',$id);
	setPetugas('PERBADANAN PUTRAJAYA',$id);
	setPetugas('PERBADANAN LABUAN',$id);
}






















/*TODO : jadikan bawah ini function email
	//email all pegawai bertugas - individually
	$qry = "SELECT Tarikh, Sesi, PegawaiBtugas FROM kal_pegawaitugas WHERE Kal_mesyuarat_id='$id'";
	$result = mysql_query($qry) or die(mysql_error());
	while($row	= mysql_fetch_array($result)){
		$pegawai = $row['PegawaiBtugas'];
		$Tarikh = Reverse($row['Tarikh']);
		$Sesi = $row['Sesi'];
		$qry_emel = "SELECT emel FROM pengguna WHERE nama='$pegawai'";
		$result_emel = mysql_query($qry_emel) or die(mysql_error());
		$rows = mysql_fetch_array($result_emel);
		$emel = $rows['emel'];
		oo 
		$send = true;
		$from = $_SESSION['emel'];		
		$headers = "From: ".$from."\n";		
		$perkara = "Jadual Pegawai Bertugas";
		$sesi = ($sesi==2)?"Dewan Negara":"Dewan Rakyat";
	
		$subject = $sistem_kal." : ".$perkara;
		$url = $link_kal.$id; 	
		$message = "Anda dikehendaki bertugas pada hari dan sesi yang telah ditetapkan. \n\n".
					"Penggal   : $penggal \n Parlimen  : $parlimen \n".
					"Mesyuarat : $mesyuarat \n Sesi      : $sesi \n\n".
					"Tarikh    : $Tarikh \n Sesi      : $Sesi \n\n".
					"Untuk maklumat selanjutnya sila klik \n\n$url";	
	
		if(mail($emel,$subject,$message,$headers))			
			echo "";
		else
			$send = false;
	}
	
	//mail("jamlee.yanggitom@treasury.gov.my",$subject,$message,$headers);
	if($send)
	{
		$msg = "<center><br /><br />Jadual Pegawai Bertugas telah disimpan. <br /><br />Emel pemberitahuan telah dihantar kepada pegawai-pegawai bertugas.</center>";
	}
*/


?>