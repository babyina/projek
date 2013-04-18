<?php
session_start();
	include("../view.php");

	$Pegawai_Agensi = $_SESSION['agensi_id'];
	$nama_pegawai = $_SESSION['nama'];
	$Jawatan = $_SESSION['jawatan'];
	
	if($Jawatan == "Ketua Setiausaha")
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
	if($view_name == "bydate"){
	
		$sortWakil = ($_GET['sortWakil']=='desc')?"desc":"asc";	

		$tarikh = ($sortTkh=="asc")?"<img src=\"../images/altasc.gif\">Tarikh Soalan<a href='index.php?action=list&view=bydate&sortTarikh=desc&sortWakil=$sortWakil'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bydate&sortTarikh=asc&sortWakil=$sortWakil'><img src=\"../images/asc.gif\" border=\"0\"></a>Tarikh<img src=\"../images/altdesc.gif\">";
	
		$yb = ($sortWakil=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=desc'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=asc'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";

		$qry_all = "SELECT parlimen.id FROM parlimen,ahli_parlimen 
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id";
		$qry = "SELECT 
					parlimen.id, 
					tkh_bentang_jawapan AS Tarikh,
					ahli_parlimen.nama AS nama_yb, 
					bentuk_soalan,
					no_soalan,perkara
				FROM 
					parlimen,
					ahli_parlimen
				WHERE 
					parlimen.ahli_dewan_id = ahli_parlimen.id
				ORDER BY 
					tkh_bentang_jawapan $sortTkh,
					nama_yb $sortWakil 
				LIMIT $offset,$pgRow";

		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("no_soalan","nama_yb","perkara","bentuk_soalan");
		$view->header = array($tarikh,"No Soalan",$yb,"Perkara","Bentuk Soalan");
		$view->key = array("id","Tarikh");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>

		<div class="tajuk">Soal Jawab Parlimen - Mengikut Tarikh Soalan</div>
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bydate&page=";
		
	}
	//----------------------------------------------------------------------------------------------------------------------------------
	if($view_name == "byJwpnAkhirSoal"){
	
		$sortWakil = ($_GET['sortWakil']=='desc')?"desc":"asc";	

		$tarikh = ($sortTkh=="asc")?"<img src=\"../images/altasc.gif\">Tarikh Soalan<a href='index.php?action=list&view=bydate&sortTarikh=desc&sortWakil=$sortWakil'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bydate&sortTarikh=asc&sortWakil=$sortWakil'><img src=\"../images/asc.gif\" border=\"0\"></a>Tarikh<img src=\"../images/altdesc.gif\">";
	
		$yb = ($sortWakil=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=desc'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=asc'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";
		
		if($isPegawai){		
		
		$qry = "SELECT parlimen.id, 
					tkh_bentang_jawapan AS Tarikh,
					ahli_parlimen.nama AS nama_yb, 
					bentuk_soalan,
					no_soalan,perkara
				FROM 
					parlimen,
					ahli_parlimen,
					parlimen_agensi
				WHERE 
				parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
				AND parlimen.status ='9' AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi')
				ORDER BY 
					tkh_bentang_jawapan $sortTkh,
					nama_yb $sortWakil 
				LIMIT $offset,$pgRow";
				
		$view->query_all = $qry;		
		}else {

		$qry_all = "SELECT 
					parlimen.id	
				FROM 
					parlimen,
					ahli_parlimen
				WHERE 
					parlimen.ahli_dewan_id = ahli_parlimen.id AND
					parlimen.status = '9'";
		$qry = "SELECT 
					parlimen.id, 
					tkh_bentang_jawapan AS Tarikh,
					ahli_parlimen.nama AS nama_yb, 
					bentuk_soalan,
					no_soalan,perkara
				FROM 
					parlimen,
					ahli_parlimen
				WHERE 
					parlimen.ahli_dewan_id = ahli_parlimen.id AND
					parlimen.status = '9'
				ORDER BY 
					tkh_bentang_jawapan $sortTkh,
					nama_yb $sortWakil 
				LIMIT $offset,$pgRow";

		$view->query_all = $qry_all;
		}
		$view->query = $qry;
		$view->col = array("no_soalan","nama_yb","perkara","bentuk_soalan");
		$view->header = array($tarikh,"No Soalan",$yb,"Perkara","Bentuk Soalan");
		$view->key = array("id","Tarikh");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Senarai Jawapan Akhir Soal Jawab</div>
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=byJwpnAkhirSoal&page=";
		
	}
 	//----------------------------------------------------------------------------------------------------------------------------------


	if($view_name == "byyb"){
	
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$name = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=byyb&sort=desc&start=$start'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a text-decoration:none; href='index.php?action=list&view=byyb&sort=asc&start=$start'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";	
		$sortAhli = $start<>""?" AND ahli_parlimen.nama LIKE '$start%'":"";
		$qry_all = "SELECT parlimen.id FROM parlimen,ahli_parlimen 
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id";
		$qry = "SELECT parlimen.id, DATE_FORMAT(tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,no_soalan,perkara
				FROM parlimen,ahli_parlimen
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli
				ORDER BY ahli_parlimen.nama $sort LIMIT $offset,$pgRow";
		//echo $qry;

		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("Tarikh","no_soalan","perkara","bentuk_soalan");
		$view->header = array($name,"Tarikh","No Soalan","Perkara","Bentuk Soalan");
		$view->key = array("id","nama_yb");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Senarai Untuk Tindakan - Mengikut Nama Y.B</div>
		<?php
		$view->out();
		
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=byyb&sort=$sort&start=$start&page=";
		echo "<br/><div class=\"box\">";
		for($i=97;$i<=122;$i++){
		?>
			<a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list&view=byyb&sort=<?php echo $sort ?>&start=<?php echo chr($i) ?>"><?php echo chr($i-32) ?></a>&nbsp&nbsp;
		<?php
		}
		echo "<div>";	
	}

	//----------------------------------------------------------------------------------------------------------------------------------


	if($view_name == "byno"){
	
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$name = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=byyb&sort=desc&start=$start'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a text-decoration:none; href='index.php?action=list&view=byyb&sort=asc&start=$start'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";	
		$sortAhli = $start<>""?" AND ahli_parlimen.nama LIKE '$start%'":"";
		$qry_all = "SELECT parlimen.id FROM parlimen,ahli_parlimen 
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id";
		$qry = "SELECT parlimen.id, DATE_FORMAT(tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,no_soalan,perkara
				FROM parlimen,ahli_parlimen
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli
				ORDER BY no_soalan ASC LIMIT $offset,$pgRow";
		//echo $qry;

		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("Tarikh","nama_yb","perkara","bentuk_soalan");
		$view->header = array("No Soalan","Tarikh","Nama Y.B","Perkara","Bentuk Soalan");
		$view->key = array("id","no_soalan");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Soal Jawab Parlimen - Mengikut Nombor Soalan</div>
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=byno&sort=$sort&start=$start&page=";
	}



	//----------------------------------------------------------------------------------------------------------------------------------


	if($view_name == "bystatus"){
		$tarikh = ($sortTkh=="asc")?"<img src=\"../images/altasc.gif\">Tarikh<a href='index.php?action=list&view=bystatus&sortTarikh=desc&sortWakil=$sortWakil'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bystatus&sortTarikh=asc&sortWakil=$sortWakil'><img src=\"../images/asc.gif\"></a>Tarikh<img src=\"../images/altdesc.gif\">";
	
		
		if($isPegawai){		
		
		$qry = "SELECT DISTINCT parlimen.status AS status, parlimen.id, parlimen.tkh_bentang_jawapan AS Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,no_soalan, parlimen.status, parlimen.perkara, parlimen.agensi
				FROM parlimen,ahli_parlimen,parlimen_agensi
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
				AND parlimen.status >1 AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi')
				ORDER BY parlimen.tkh_bentang_jawapan DESC LIMIT $offset,$pgRow";
				
		$view->query_all = $qry;		
		}else {
		$qry_all = "SELECT parlimen.id FROM parlimen,ahli_parlimen,parlimen_agensi 
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id ";
		
		$qry = "SELECT parlimen.status AS status, parlimen.id, parlimen.tkh_bentang_jawapan AS Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,no_soalan, parlimen.status,perkara
				FROM parlimen,ahli_parlimen
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.status >1 
				ORDER BY parlimen.tkh_bentang_jawapan DESC LIMIT $offset,$pgRow";
				
			$view->query_all = $qry_all;	
				}

		
		$view->query = $qry;
		$view->col = array("Tarikh","no_soalan","nama_yb","perkara","bentuk_soalan");
		$view->header = array("Tarikh","No Soalan","Nama Y.B","Perkara","Bentuk Soalan");
		$view->cat = "status";
		$view->key = array("id","status");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Soal Jawab Parlimen - Mengikut Status</div>
		<?php
		$view->OutCat();
		
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bystatus&sortTarikh=$sortTkh&sortWakil=$sortWakil&page=";
	}
	//----------------------------------------------------------------------------------------------------------------------------------


	if($view_name == "imbasan"){
	
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$name = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=byyb&sort=desc&start=$start'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a text-decoration:none; href='index.php?action=list&view=byyb&sort=asc&start=$start'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";	
		$sortAhli = $start<>""?" AND ahli_parlimen.nama LIKE '$start%'":"";
		$qry_all = "SELECT COUNT(*) AS total FROM parlimen WHERE parlimen.status=0";

		$qry = "SELECT parlimen.id,parlimen.perkara, DATE_FORMAT(tkh_mula_bersidang,'%d/%m/%Y') AS Tarikh,parlimen_lampiran.nama_fail
				FROM parlimen,parlimen_lampiran
				WHERE parlimen_lampiran.parlimen_id = parlimen.id AND parlimen.status=0
				ORDER BY tkh_mula_bersidang LIMIT $offset,$pgRow";
	
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("perkara",);
		$view->header = array("Tarikh Persidangan","Perkara");
		$view->key = array("id","Tarikh");
		$view->ref = "index.php?action=details&id=";
		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Senarai Imbasan Soal Jawab Parlimen</div>
		<?php
		$view->out();
		
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=imbasan&sort=$sort&start=$start&page=";
	}

	//----------------------------------------------------------------------------------------------------------------------------------

	if($view_name =='perhatianSoal' || $view_name ==''){

		if($isPegawai){
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.agensi, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen_agensi.status_pindaan  
			FROM parlimen, ahli_parlimen, parlimen_agensi
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
			AND (parlimen.status = 21 OR parlimen.status=22 OR ( parlimen.status=23 AND (parlimen_agensi.status = 1 OR parlimen_agensi.status = 0))OR (parlimen.status = 10 AND parlimen_agensi.nama_pegawai='$nama_pegawai' AND parlimen_agensi.status_pindaan=0)) 
			AND (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') GROUP BY parlimen.id ORDER BY parlimen.id";
			}
		elseif($isHEK)
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 1 OR parlimen.status = 3 OR parlimen.status=5 OR parlimen.status = 7 OR parlimen.status=8 OR parlimen.status=23) ORDER BY parlimen.id";
	
		elseif($isBoth)
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status, parlimen.penyemak  
			FROM parlimen, ahli_parlimen
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 6 OR parlimen.status = 4) AND (parlimen.penyemak LIKE '$Jawatan') ORDER BY parlimen.id";
	
		elseif($isPengesahan)	
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen.penyemak  
			FROM parlimen, ahli_parlimen
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 6) AND (parlimen.penyemak LIKE '$Jawatan') ORDER BY parlimen.id";
	
		elseif($isPengurusan)
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen.penyemak 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 4)  AND (parlimen.penyemak LIKE '$Jawatan') ORDER BY parlimen.id";
			
		//echo $qry;
					
		$view->query_all = $qry; 
		$view->query = $qry;
		$view->col = array("Tarikh","NoSoalan","AhliDewan","perkara","BentukSoalan");		
		$view->header = array("Tarikh<br>Bentang<br>Soalan","No Soalan","Nama Y.B","Perkara","Bentuk Soalan");
		$view->cat = "status";
		$view->key = array("id","status");
		$view->ref = "index.php?action=details&id=";
		$view->query($conn,$db_voffice);	
		?>
		<div class="tajuk">Senarai Untuk Tindakan - Soal Jawab Parlimen</div>
		<?php
		$view->outCat();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=perhatian&page=";	
	}

	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
?>