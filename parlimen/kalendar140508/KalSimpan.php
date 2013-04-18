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
//				Isnin => pagi=kwp,dbkl; ptg=kwp,ppjaya   //kwp,dbkl
//				Selasa => pagi=kwp,dbkl; ptg=kwp,ppjaya	 //kwp,ppj
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
	$tarikhMulaDR	= MysqlDate($_POST['tarikhMulaDR']);
	$tarikhAkhirDR	= MysqlDate($_POST['tarikhAkhirDR']);
	$tarikhMulaDN	= MysqlDate($_POST['tarikhMulaDN']);
	$tarikhAkhirDN	= MysqlDate($_POST['tarikhAkhirDN']);
	
	$newdocKal 	= ($_GET['action']=='newdocKal')?true:false;



//NEW
if($newdocKal){
	$qry = "INSERT INTO kal_mesyuarat (Parlimen,Penggal,Mesyuarat,TarikhMulaDR,TarikhAkhirDR,TarikhMulaDN,TarikhAkhirDN)
			VALUES('$parlimen','$penggal','$mesyuarat','$tarikhMulaDR','$tarikhAkhirDR','$tarikhMulaDN','$tarikhAkhirDN')";
	mysql_query($qry,$conn) or die('kalsimpan.php = '.mysql_error());

	$id	 = mysql_insert_id();
	$mode	= "rakyat";
	setCalendar($id, $tarikhMulaDR, $tarikhAkhirDR, $mode); //setkan agensi dan pegawai yg bertugas utk dewan rakyat
	$mode	= "negara";
	setCalendar($id, $tarikhMulaDN, $tarikhAkhirDN, $mode); //setkan agensi dan pegawai yg bertugas utk dewan negara
}

//UPDATE
else{

	echo $tarikhMulaDN;
	$qry = "UPDATE kal_mesyuarat SET 
			Parlimen='$parlimen', 
			Penggal='$penggal', 
			Sesi='$sesi', 
			Mesyuarat='$mesyuarat', 
			TarikhMulaDR='$tarikhMulaDR', 
			TarikhAkhirDR='$tarikhAkhirDR',
			TarikhMulaDN='$tarikhMulaDN', 
			TarikhAkhirDN='$tarikhAkhirDN'
			WHERE Kal_mesyuarat_id = '$id' LIMIT 1";
	$msg = "<center>Jadual Pegawai Bertugas telah dikemaskini</center>";
	mysql_query($qry,$conn) or die('kalsimpan.php = '.mysql_error());
	
	
	
}


echo "<center><br><br><a href=\"index.php?action=detailsKal&id=".$id."\">kembali semula</a></center>";
//Redirect
$url	= "index.php?action=detailsKal&id=".$id;
redirect($url);
//exit;



function setCalendar($id, $tarikhMulaDR, $tarikhAkhirDR, $mode){
//untuk compute jadual bertugas semasa create record
	$weekCounter	= 0;
	
	//weekCounter untuk dewan negara
	if ($mode=='negara'){
		$qryMinggu	= "SELECT MAX(Minggu) AS maxWeek FROM kal_pegawaitugas WHERE Kal_mesyuarat_id='$id'";
		$rsMinggu	= mysql_query($qryMinggu);
		$rowMinggu	= mysql_fetch_array($rsMinggu);
		$weekCounter	= $rowMinggu['maxWeek'];		
	}

	$tkh	= tarikhAvailable($tarikhMulaDR, $tarikhAkhirDR);  //dapat array tarikh business day. except jumaat, sabtu, ahad dan cuti
	foreach($tkh as $tkhTugas){
		$currWeek		= findWeek($tkhTugas);
		$dplcateWeek 	= ($currWeek==$preWeek)? true:false;
		
		if (!$dplcateWeek){
			$weekCounter++;
		}

		if(checkCuti($tkhTugas)){ //Entry sekiranya tarikh ini = cuti
			$qryTugas	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
							VALUES ('$id', '$tkhTugas', 'CUTI', 'CUTI', '$mode', '$weekCounter')";
			mysql_query($qryTugas) or die(mysql_error());
		}
		//Entry selain daripada hari cuti
		else{
			if($mode=='rakyat' && $tkhTugas==$tarikhMulaDR){ //setkan entry utk hari pertama = titah agong
				$qryTugas1	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', 'KWP', 'PAGI','$mode', '$weekCounter')";
				$qryTugas2	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', 'DBKL', 'PAGI','$mode', '$weekCounter')";
				$qryTugas3	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', '', 'PETANG','$mode', '$weekCounter')";
				$qryTugas4	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', '', 'PETANG','$mode', '$weekCounter')"; 
			}
			else{
				
				//PAGI
				$qryTugas1	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
							   VALUES ('$id', '$tkhTugas', 'KWP', 'PAGI','$mode', '$weekCounter')";
							   
				if(hari($tkhTugas)=='Mon') {
				$qryTugas2	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
							   VALUES ('$id', '$tkhTugas', 'DBKL', 'PAGI','$mode', '$weekCounter')";
				}
								
				if(hari($tkhTugas)=='Tue') {
				$qryTugas2	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
							   VALUES ('$id', '$tkhTugas', 'PERBADANAN PUTRAJAYA', 'PAGI','$mode', '$weekCounter')";
				}
				
				if(hari($tkhTugas)=='Wed'){
				$qryTugas2	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
							   VALUES ('$id', '$tkhTugas', 'DBKL', 'PAGI','$mode', '$weekCounter')";
				}
				
				//Sekiranya hari=khamis, maka PERBADANAN LABUAN akan bertugas
				if(hari($tkhTugas)=='Thu'){
				$qryTugas2	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
							   VALUES ('$id', '$tkhTugas', 'PERBADANAN LABUAN', 'PAGI','$mode', '$weekCounter')";
				}
				
				//PETANG
				$qryTugas3	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', 'KWP', 'PETANG','$mode', '$weekCounter')";
				$qryTugas4	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
								VALUES ('$id', '$tkhTugas', 'PERBADANAN PUTRAJAYA', 'PETANG','$mode', '$weekCounter')"; 
				//Sekiranya hari=rabu, maka PERBADANAN LABUAN akan bertugas
				if(hari($tkhTugas)=='Wed'){ 
					$qryTugas4	= "INSERT INTO kal_pegawaitugas (Kal_mesyuarat_id, Tarikh, Agensi, Sesi, Dewan, Minggu) 
									VALUES ('$id', '$tkhTugas', 'PERBADANAN LABUAN', 'PETANG','$mode', '$weekCounter')";
				}
			}		
		
			mysql_query($qryTugas1) or die(mysql_error());
			mysql_query($qryTugas2) or die(mysql_error());
			//mysql_query($qryTugas3) or die(mysql_error());
			//mysql_query($qryTugas4) or die(mysql_error());
		}
		$preWeek	= $currWeek;
	}
	
	//Automate nama petugas by giliran
	setPetugas('DBKL',$id);
	setPetugas('KWP',$id);
	setPetugas('PERBADANAN PUTRAJAYA',$id);
	setPetugas('PERBADANAN LABUAN',$id);
}






















//TODO : jadikan bawah ini function email
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



?>