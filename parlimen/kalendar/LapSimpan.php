<?php
//Get id if available
$id			= $_GET['id'];

//butir2 persidangan
$sesiDewan 		= $_POST['sesiDewan'];
$tarikhSidang 	= MysqlDate($_POST['tarikhSidang']);
$hari		 	= $_POST['hari'];
$sesi			= $_POST['sesi'];
$masaTangguh	= $_POST['masaTangguh'];
$pegawaiNama	= $_POST['pegawaiNama'];
$pegawaiBhg		= $_POST['pegawaiBhg'];
$pegawaiTlfn	= $_POST['pegawaiTlfn'];
$tarikhLaporan	= MysqlDate($_POST['tarikhLaporan']);
$tarikhSidang2	= MysqlDate($_POST['tarikhSidang2']);
$masaSidang2	= $_POST['masaSidang2'];

//sesi jawapan mulut
$jumSoalan		= $_POST['jumSoalan'];
$jumJawab		= $_POST['jumJawab'];
$sahSoalanMent	= $_POST['sahSoalanMent'];
$bilSoalan		= $_POST['bilSoalan'];
$sahSoalanTamb	= $_POST['sahSoalanTamb'];
$sahSoalKaitan	= $_POST['sahSoalanBerkaitan'];

//perbahasan titah ucapan
$rang1			= $_POST['rang1'];
$rang2			= $_POST['rang2'];
$rang3			= $_POST['rang3'];
$rang4			= $_POST['rang4'];
$statusRang1	= $_POST['statusRang1'];
$statusRang2	= $_POST['statusRang2'];
$statusRang3	= $_POST['statusRang3'];
$statusRang4	= $_POST['statusRang4'];
$sahIsuBerkaitan= $_POST['sahIsuBerkaitan'];
$sahRangUndang	= $_POST['sahRangUndang'];

$newdocLap 	= ($_GET['action']=='newdocLap')? true:false;

if($newdocLap){
	//INSERT
	$qry	= "INSERT INTO kal_lapdwn SET
					SesiDewan='$sesiDewan',
					TarikhSidang='$tarikhSidang',
					Hari='$hari',
					MasaTangguh='$masaTangguh',
					PgwNama='$pegawaiNama',
					PgwBhg='$pegawaiBhg',
					PgwTelefon='$pegawaiTlfn',
					TarikhLaporan='$tarikhLaporan',
					TarikhSidang2='$tarikhSidang2',
					MasaSidang2='$masaSidang2'";
	echo $qry;
	mysql_query($qry,$conn) or die('LapSimpan.php = '.mysql_error());
	$id	 = mysql_insert_id();
	$url = "index.php?action=editLap&id=".$id;
}
else{
	//UPDATE
	$qry = "UPDATE kal_lapdwn SET
				SesiDewan='$sesiDewan',
				TarikhSidang='$tarikhSidang',
				Hari='$hari',
				Sesi='$sesi',
				MasaTangguh='$masaTangguh',
				PgwNama='$pegawaiNama',
				PgwBhg='$pegawaiBhg',
				PgwTelefon='$pegawaiTlfn',
				TarikhLaporan='$tarikhLaporan',
				TarikhSidang2='$tarikhSidang2',
				MasaSidang2='$masaSidang2',
				JumSoalan='$jumSoalan',
				JumJawab='$jumJawab',
				SahSoalanMent='$sahSoalanMent',
				BilSoalan='$bilSoalan',
				SahSoalanTamb='$sahSoalanTamb',
				SahSoalKaitan='$sahSoalKaitan',
				SahIsuBerkaitan='$sahIsuBerkaitan',
				Rang1='$rang1',
				Rang2='$rang2',
				Rang3='$rang3',
				Rang4='$rang4',
				StatusRang1='$statusRang1',
				StatusRang2='$statusRang2',
				StatusRang3='$statusRang3',
				StatusRang4='$statusRang4',
				SahRangUndang='$sahRangUndang'
			WHERE Kal_lapdwn_id='$id'";
	$url = "index.php?action=listLap&view=bynama";
	echo $qry;
	mysql_query($qry,$conn) or die('LapSimpan.php = '.mysql_error());
}

//Redirect
redirect($url);

?>
