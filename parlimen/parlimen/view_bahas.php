<?php
session_start();
	include("../view.php");

	$Pegawai_Agensi = $_SESSION['agensi_id'];
	$nama_pegawai = $_SESSION['nama'];
	$Jawatan = $_SESSION['jawatan'];
	
	//in future get butiran from katakunci where kod=KSU
	if($Jawatan == "KSP")
		$Jawatan = "$Jawatan%";
	else
		$Jawatan = "%$Jawatan%";
	
	$isPegawai = checkACL($_SESSION['userid'],2,$row2['agensi_id'],$conn);	
	$isHEK = checkOfficer($_SESSION['userid'],3,$conn);	
	$isPengurusan = checkOfficer($_SESSION['userid'],4,$conn);
	$isPengesahan = checkOfficer($_SESSION['userid'],5,$conn);
	
	if($isPengurusan && $isPengesahan)
		$isBoth = true;
		
	$pgNum = 1;
	$pgRow = 25;
	
	if(isset($_GET['page'])){
		$pgNum = $_GET['page'];
	}else
		$pgNum = 1;
	$offset =($pgNum -1)*$pgRow;

	$view_name = $_GET['view'];
	$sortTkh = ($_GET['sortTarikh']=='desc')?"desc":"asc";

	$view = new View();
	
	//----------------------------------------------------------------------------------------------------------------------------------
	

	if($view_name =='perhatian'){
	$view->col = array("Sesi","Tajuk");		
	$view->header = array("Tarikh Mula","Sesi Dewan","Tajuk");
	$view->key = array("id","Tarikh");
	if($isPegawai)
		$qry = "SELECT sesi_bahas.id,sesi_bahas.tkh_mula AS Tarikh, sesi_bahas.sesi AS Sesi, sesi_bahas.tajuk AS Tajuk FROM sesi_bahas, bahas_agensi 
		WHERE sesi_bahas.id=bahas_agensi.main_id 
		AND (sesi_bahas.status = 21 OR sesi_bahas.status=22 OR (sesi_bahas.status=10 AND bahas_agensi.nama_pegawai='$nama_pegawai' AND bahas_agensi.status_pindaan=0)) 
		AND bahas_agensi.agensi_id='$Pegawai_Agensi' ORDER BY sesi_bahas.id";
		
	elseif($isHEK)
		$qry = "SELECT sesi_bahas.id,sesi_bahas.tkh_mula AS Tarikh, sesi_bahas.sesi AS Sesi, sesi_bahas.tajuk AS Tajuk FROM sesi_bahas
		WHERE (sesi_bahas.status = 3 OR sesi_bahas.status=5 OR sesi_bahas.status = 7 OR sesi_bahas.status=8) ORDER BY sesi_bahas.id";

	elseif($isBoth)
		$qry = "SELECT sesi_bahas.id,sesi_bahas.tkh_mula AS Tarikh, sesi_bahas.sesi AS Sesi, sesi_bahas.tajuk AS Tajuk FROM sesi_bahas
		WHERE (sesi_bahas.status = 4 OR sesi_bahas.status = 6) AND (sesi_bahas.penyemak LIKE '$Jawatan') ORDER BY sesi_bahas.id";

	elseif($isPengurusan)
		$qry = "SELECT sesi_bahas.id,sesi_bahas.tkh_mula AS Tarikh, sesi_bahas.sesi AS Sesi, sesi_bahas.tajuk AS Tajuk FROM sesi_bahas
		WHERE (sesi_bahas.status = 4) AND (sesi_bahas.penyemak LIKE '$Jawatan') ORDER BY sesi_bahas.id";
		
	elseif($isPengesahan)	
		$qry = "SELECT sesi_bahas.id,sesi_bahas.tkh_mula AS Tarikh, sesi_bahas.sesi AS Sesi, sesi_bahas.tajuk AS Tajuk FROM sesi_bahas
		WHERE (sesi_bahas.status = 6) AND (sesi_bahas.penyemak LIKE '$Jawatan') ORDER BY sesi_bahas.id";
		
		//echo $qry;
		
	$view->query_all = $qry; 		
	$view->query = $qry;
	$view->query2($conn,$db_voffice);	
	$view->ref = "index.php?action=detailsbahas&id=";
	?>
	<div style="font-family:Arial;font-size:9pt;margin-top:10px;height:40px">
		<strong>Senarai Untuk Tindakan - Daftar Sesi Perbahasan</strong>
	</div>
	<?php
	$view->out();
	$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=listview&view=perhatian&page=";	
}

	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
?>