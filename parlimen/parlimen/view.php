<?php
session_start();
	include("../view.php"); 
	//$findme2=array();
    $findme    = 'pa';
	 $findme2 = array("tksp (p)","tksp (d)","tksp (s&k)","tksp(p)","tksp(d)","tksp (s&k)","tksp (s & k)");
	    // $findme2='tksp (p)';
	  // $findme3    = '(d)';
	   //$findme4    = '&';
	$Pegawai_Agensi = $_SESSION['agensi_id'];
	$nama_pegawai = $_SESSION['nama'];
	$Jawatan = $_SESSION['jawatan'];
	
	if($Jawatan == "Ketua Setiausaha")
		$Jawatan = "$Jawatan%";
	else
		$Jawatan = "%$Jawatan%";
		
	$pos1 = stristr($Jawatan, $findme);
	//$pos2= stristr($Jawatan, $findme2);
	//$pos3= stristr($Jawatan, $findme3);
	//$pos4= stristr($Jawatan, $findme4);
	
	//$findme2 = explode(',',$findme2);
	
	//if ($pos1 == false) {
    //echo "The string '$findme' was not found in the string '$mystring1'";
//}

	if ($pos1 != false) {
	

while(list( ,$value) = each($findme2)){
	 $pos2= stristr($Jawatan,$value);
	  if ($pos2 != false)
	 {
	  $Jawatan=$value;
	 $Jawatan = "%$Jawatan%"; 
	
	 }
}

}
	
	$isPegawai = checkACL($_SESSION['userid'],2,$row2['agensi_id'],$conn);	
	$isHEK = checkOfficer($_SESSION['userid'],3,$conn);	
	$isPengurusan = checkOfficer($_SESSION['userid'],4,$conn);
	//$isPengurusan = checkOfficer($_SESSION['userid'],11,$conn);
	//$isPengesahan = checkOfficer($_SESSION['userid'],5,$conn);
	$isKSP = checkOfficer($_SESSION['userid'],8,$conn);
	$isMK = checkOfficer($_SESSION['userid'],5,$conn);
	$isSUSK_PTTK 	= checkOfficer($_SESSION['userid'],11,$conn);	
	if($isPengurusan && $isPengesahan)
		$isBoth = true;

	$pgNum = 0;
	$pgRow = 30; 
	
	if(isset($_GET['page'])){
		$pgNum = $_GET['page'];
	}else
		$pgNum = 1;
	$offset =($pgNum -1)*$pgRow;

	$view_name = $_GET['view'];
	//$sortTkh = ($_GET['sortTarikh']=='desc')?"desc":"asc";
	$sortTkh = ($_GET['sortTarikh']=='asc')?"asc":"desc";

	$view = new View();
	
	

$act= $_GET['action'];

if(($view_name == 'bydate') || ($view_name == 'byno') || ($view_name == 'byagensi') || ($view_name == 'byyb') ||($view_name == 'bystatus')||($view_name == 'bylisan') ||($view_name == 'bybertulis')){ ?>
	<table width=100% border=0 cellspacing=1 style="border-collapse:collapse">
	<tr valign="top">
		    <td width="8%">Mesyuarat :</td>
		    <td width="91%"><a href="index.php?action=<?php echo $act?>&view=<?php echo $view_name?>&meet=Pertama">Pertama</a> || 
			<a href="index.php?action=<?php echo $act?>&view=<?php echo $view_name?>&meet=Kedua">Kedua</a> || 
			<a href="index.php?action=<?php echo $act?>&view=<?php echo $view_name?>&meet=Ketiga">Ketiga</a> ||
			<!--<a href="index.php?action=<?php echo $act?>&view=<?php echo $view_name?>&meet=Keempat">Empat</a> || 
			<a href="index.php?action=<?php echo $act?>&view=<?php echo $view_name?>&meet=Kelima">Lima</a> || -->
			</td>
		    <td width="1%">&nbsp;</td>
      </tr><tr valign="top">
		    <td></td>
		    <td>
			</td>
		    <td>&nbsp;</td>
	      </tr>
	</table>
  <?php	}
		
		$meet = $_GET['meet'];
		$tahun = date('Y');// asal
		//$tahun_sebelum=date('Y',strtotime("-1 years")); on 06032012
        $tahun_sebelum=date('Y'); 
		//$tahun = date('2009');// for testing year 2009  
		
		
		if ($meet != ""){$query_meet = "AND parlimen.mesyuarat = '$meet'";} else{ $query_meet == "";}
	//----------------------------------------------------------------------------------------------------------------------------------
	if($view_name == "bydate"){
		
		$sortWakil = ($_GET['sortWakil']=='desc')?"desc":"asc";	

		$tarikh = ($sortTkh=="asc")?"<img src=\"../images/altasc.gif\">Tarikh<br>Jawab<br>Soalan<br>Di Parlimen<a href='index.php?action=list&view=bydate&sortTarikh=desc&sortWakil=$sortWakil'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bydate&sortTarikh=asc&sortWakil=$sortWakil'><img src=\"../images/asc.gif\" border=\"0\"></a>Tarikh<br>Jawab<br>Soalan<br>Di Parlimen<img src=\"../images/altdesc.gif\">";
	
		$yb = ($sortWakil=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=desc'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=asc'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";
		
		if($isPegawai){	
		$qry_all = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		parlimen.tkh_bentang_jawapan AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.mesyuarat,
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (parlimen.status!='44')  AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		$query_meet";
		
		$qry = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		parlimen.tkh_bentang_jawapan AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		CONVERT(no_soalan,DECIMAL) AS no_soalan,  
		parlimen.mesyuarat,
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (parlimen.status!='44')  AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
		ORDER BY parlimen.tkh_bentang_jawapan $sortTkh,no_soalan asc,
		nama_yb $sortWakil 
		LIMIT $offset,$pgRow";
				
		
		}
		
		elseif($isPengurusan )
		{
		$qry_all = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		parlimen.tkh_bentang_jawapan AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.mesyuarat,
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan') 
				AND (parlimen.status!='44') 
				AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
				$query_meet";
		$qry = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		parlimen.tkh_bentang_jawapan AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		CONVERT(no_soalan,DECIMAL) AS no_soalan, 
		parlimen.mesyuarat,
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan') 
				AND (parlimen.status!='44') 
				AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
		ORDER BY parlimen.tkh_bentang_jawapan $sortTkh,no_soalan asc,
		nama_yb $sortWakil 
		LIMIT $offset,$pgRow";
				
		
		
		
		}
		else {
		$qry_all = "SELECT parlimen.id FROM parlimen,ahli_parlimen 
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id
				AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet";
		$qry = "SELECT 
					parlimen.id, parlimen.mesyuarat,
					tkh_bentang_jawapan AS Tarikh,
					ahli_parlimen.nama AS nama_yb, 
					bentuk_soalan,
					CONVERT(no_soalan,DECIMAL) AS no_soalan,perkara
				FROM 
					parlimen,
					ahli_parlimen
				WHERE 
					parlimen.ahli_dewan_id = ahli_parlimen.id AND (parlimen.status!='44') 
					AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
					$query_meet
				ORDER BY 
					tkh_bentang_jawapan $sortTkh, no_soalan asc,
					nama_yb $sortWakil 
				LIMIT $offset,$pgRow";
			
				
	
		//$view->query_all = $qry;

		}
		$view->query_all = $qry_all;
		$bil_sil="1";
		$view->query = $qry;
		$view->col = array("no_soalan","nama_yb","perkara","bentuk_soalan");
		//$view->header = array($tarikh,"No Soalan",$yb,"Perkara","Bentuk Soalan","Bil");
		$view->header = array($tarikh,"No Soalan",$yb,"Perkara","Bentuk Soalan");
		$view->key = array("id","Tarikh","no_soalan");
		$view->ref = "index.php?action=details&id=";
		$view->query2($conn,$db_voffice); 
		//$view->Query($conn,$db_voffice); 
		?>

		<div class="tajuk">Soal Jawab Parlimen - Mengikut Tarikh Soalan </div>
		<?php
		$view->Outtarikh();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bydate&meet=$meet&page=";
		
	}
	//----------------------------------------------------------------------------------------------------------------------------------
	if($view_name == "byJwpnAkhirSoal"){
	
		$sortWakil = ($_GET['sortWakil']=='desc')?"desc":"asc";	

		$tarikh = ($sortTkh=="asc")?"<img src=\"../images/altasc.gif\">Tarikh<br>Jawab<br>Soalan<br>Di Parlimen<a href='index.php?action=list&view=byJwpnAkhirSoal&sortTarikh=desc&sortWakil=$sortWakil'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=byJwpnAkhirSoal&sortTarikh=asc&sortWakil=$sortWakil'><img src=\"../images/asc.gif\" border=\"0\"></a>Tarikh<br>Jawab<br>Soalan<br>Di Parlimen<img src=\"../images/altdesc.gif\">";
	
		$yb = ($sortWakil=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=desc'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=byJwpnAkhirSoal&sortTarikh=$sortTkh&sortWakil=asc'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";
		
		if($isPegawai){		
		$qry_all = "SELECT parlimen.id, 
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
				AND parlimen.status ='9' AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')  ";
		
		
		
		
		$qry = "SELECT parlimen.id, 
					tkh_bentang_jawapan AS Tarikh,
					ahli_parlimen.nama AS nama_yb, 
					bentuk_soalan,
					CONVERT(no_soalan,DECIMAL) AS no_soalan, perkara
				FROM 
					parlimen,
					ahli_parlimen,
					parlimen_agensi
				WHERE 
				parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
				AND parlimen.status ='9' AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY 
					tkh_bentang_jawapan $sortTkh,no_soalan asc,
					nama_yb $sortWakil 
				LIMIT $offset,$pgRow";
				
		$view->query_all = $qry;		
		}
		elseif($isPengurusan )
		{
		$qry_all = "SELECT parlimen.id, 
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
				AND parlimen.status ='9' AND  (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') ";
		
		
		$qry = "SELECT parlimen.id, 
					tkh_bentang_jawapan AS Tarikh,
					ahli_parlimen.nama AS nama_yb, 
					bentuk_soalan,
					CONVERT(no_soalan,DECIMAL) AS no_soalan, perkara
				FROM 
					parlimen,
					ahli_parlimen,
					parlimen_agensi
				WHERE 
				parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
				AND parlimen.status ='9' AND  (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY 
					tkh_bentang_jawapan $sortTkh,no_soalan asc,
					nama_yb $sortWakil 
				LIMIT $offset,$pgRow";
				
		$view->query_all = $qry;		
	}
		
		
		
		else {

		$qry_all = "SELECT 
					parlimen.id	
				FROM 
					parlimen,
					ahli_parlimen
				WHERE 
					parlimen.ahli_dewan_id = ahli_parlimen.id AND
					parlimen.status = '9'AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')";
		$qry = "SELECT 
					parlimen.id, 
					tkh_bentang_jawapan AS Tarikh,
					ahli_parlimen.nama AS nama_yb, 
					bentuk_soalan,
					CONVERT(no_soalan,DECIMAL) AS no_soalan, perkara
				FROM 
					parlimen,
					ahli_parlimen
				WHERE 
					parlimen.ahli_dewan_id = ahli_parlimen.id AND
					parlimen.status = '9' AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY 
					tkh_bentang_jawapan $sortTkh,no_soalan asc, 
					nama_yb $sortWakil 
				LIMIT $offset,$pgRow";

		
		}
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("no_soalan","nama_yb","perkara","bentuk_soalan");
		$view->header = array($tarikh,"No Soalan",$yb,"Perkara","Bentuk Soalan");
		$view->key = array("id","Tarikh","no_soalan"); 
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Senarai Jawapan Akhir Soal Jawab</div>
		<?php
		$view->Outtarikh();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=byJwpnAkhirSoal&meet=$meet&page=";
		
	}
 	//----------------------------------------------------------------------------------------------------------------------------------
    
		
	if($view_name == "bydrafjwp"){
	
		$sortWakil = ($_GET['sortWakil']=='desc')?"desc":"asc";	

		$tarikh = ($sortTkh=="asc")?"<img src=\"../images/altasc.gif\">Tarikh Soalan<a href='index.php?action=list&view=byJwpnAkhirSoal&sortTarikh=desc&sortWakil=$sortWakil'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bydrafjwp&sortTarikh=asc&sortWakil=$sortWakil'><img src=\"../images/asc.gif\" border=\"0\"></a>Tarikh<img src=\"../images/altdesc.gif\">";
	
		$yb = ($sortWakil=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=desc'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bydrafjwp&sortTarikh=$sortTkh&sortWakil=asc'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";
		
		if($isPegawai){		
		
		$qry_all = "SELECT parlimen.id, 
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
				AND parlimen.status ='9' AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')";
		
		
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
				AND parlimen.status ='9' AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY 
					tkh_bentang_jawapan $sortTkh,
					nama_yb $sortWakil 
				LIMIT $offset,$pgRow";
				
			
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
					(parlimen.status = '4' OR parlimen.status = '5') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY 
					tkh_bentang_jawapan $sortTkh,
					nama_yb $sortWakil 
				LIMIT $offset,$pgRow";

		
		}
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("no_soalan","nama_yb","perkara","bentuk_soalan");
		$view->header = array($tarikh,"No Soalan",$yb,"Perkara","Bentuk Soalan","Bil"); 
		$view->key = array("id","Tarikh");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Senarai Draf Jawapan  Soal Jawab</div>
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bydrafjwp&meet=$meet&page=";
		
	}
 	//----------------------------------------------------------------------------------------------------------------------------------


	if($view_name == "byyb"){
	
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$name = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=byyb&sort=desc&start=$start'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a text-decoration:none; href='index.php?action=list&view=byyb&sort=asc&start=$start'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";	
		$sortAhli = $start<>""?" AND ahli_parlimen.nama LIKE '$start%'":"";
		
		if($isPegawai){	
		$qry_all = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND parlimen.id=parlimen_agensi.parlimen_id 
		AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		$query_meet";
		
		
		$qry = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND parlimen.id=parlimen_agensi.parlimen_id 
		AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		$query_meet
		ORDER BY ahli_parlimen.nama $sort, parlimen.tkh_bentang_jawapan desc
		LIMIT $offset,$pgRow";
				
		$view->query_all = $qry;		
		}
		elseif($isPengurusan )
		{
		$qry_all = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND parlimen.id=parlimen_agensi.parlimen_id 
		 AND (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan')  AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		 $query_meet";
		
		
		$qry = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND parlimen.id=parlimen_agensi.parlimen_id 
		 AND (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan')  AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		 $query_meet
		ORDER BY ahli_parlimen.nama $sort, parlimen.tkh_bentang_jawapan desc
		LIMIT $offset,$pgRow";
				
		$view->query_all = $qry;		
		}
		
		
		else
		 {
		$qry_all = "SELECT parlimen.id FROM parlimen,ahli_parlimen 
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id
				AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet";
		$qry = "SELECT parlimen.id, DATE_FORMAT(tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,no_soalan,perkara
				FROM parlimen,ahli_parlimen
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY ahli_parlimen.nama $sort, tkh_bentang_jawapan desc LIMIT $offset,$pgRow";
				
				
		
		}
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("Tarikh","no_soalan","perkara","bentuk_soalan");
		$view->header = array($name,"Tarikh<br>Jawab<br>Soalan<br>Di Parlimen","No Soalan","Perkara","Bentuk Soalan");
		$view->key = array("id","nama_yb");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Senarai Untuk Tindakan - Mengikut Nama Y.B</div>
		<?php
		$view->out();
		
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=byyb&meet=$meet&sort=$sort&start=$start&page=";
		echo "<br/><div class=\"box\">";
		for($i=97;$i<=122;$i++){
		?>
			<a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list&view=byyb&meet=<?php echo $meet ?>&sort=<?php echo $sort ?>&start=<?php echo chr($i) ?>"><?php echo chr($i-32) ?></a>&nbsp&nbsp;
		<?php
		}
		echo "<div>";	
	}

	//----------------------------------------------------------------------------------------------------------------------------------
	//by question writing
	
	if($view_name == "bybertulis"){ 
	
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$name = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a 

href='index.php?action=list&view=byyb&sort=desc&start=$start'><img src=\"../images/desc.gif\" 

border=\"0\"></a>":
		"<a text-decoration:none; 

href='index.php?action=list&view=byyb&sort=asc&start=$start'><img src=\"../images/asc.gif\" 

border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";	
		$sortAhli = $start<>""?" AND ahli_parlimen.nama LIKE '$start%'":"";
		
		if($isPegawai){
		$qry_all = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND 

parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi 

LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE 

'$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR 

YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		AND parlimen.bentuk_soalan like '%Bertulis%' $query_meet";
			
		$qry = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		CONVERT(no_soalan,DECIMAL) AS no_sol, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.sesi_dewan,
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND 

parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi 

LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE 

'$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR 

YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		AND parlimen.bentuk_soalan like '%Bertulis%' $query_meet
		ORDER BY tkh_mula_bersidang desc, no_sol asc, sesi_dewan
		LIMIT $offset,$pgRow";
				
		$view->query_all = $qry;		
		}
		elseif($isPengurusan )
		{
		$qry_all = "SELECT  parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND 

parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE 

'$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan') AND 

(YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		AND parlimen.bentuk_soalan like '%Bertulis%' $query_meet";
		$qry = "SELECT  parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		CONVERT(no_soalan,DECIMAL) AS no_sol, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.sesi_dewan,
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND 

parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE 

'$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan') AND 

(YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		AND parlimen.bentuk_soalan like '%Bertulis%' $query_meet
		
		ORDER BY tkh_mula_bersidang desc, no_sol asc, sesi_dewan
		LIMIT $offset,$pgRow";
				//ORDER BY no_soalan ASC, parlimen.tkh_bentang_jawapan desc
		$view->query_all = $qry;
		
		}
		else {
		
		
		$qry_all = "SELECT parlimen.id FROM parlimen,ahli_parlimen 
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id
				AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR 

YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
				AND parlimen.bentuk_soalan like '%Bertulis%' $query_meet";
		$qry = "SELECT parlimen.id, DATE_FORMAT(tkh_mula_bersidang,'%d/%m/%Y') AS 

Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,CONVERT(no_soalan,DECIMAL) AS no_sol,perkara,
				parlimen.sesi_dewan FROM parlimen,ahli_parlimen
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli
				AND (YEAR(tkh_mula_bersidang ) = '$tahun' OR YEAR(tkh_mula_bersidang) = 

'$tahun_sebelum')
				
				AND parlimen.bentuk_soalan like '%Bertulis%'  $query_meet
				ORDER BY tkh_mula_bersidang desc, no_sol asc, sesi_dewan LIMIT 

$offset,$pgRow";
		//echo $qry;

		
		}
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("nama_yb","perkara","bentuk_soalan","sesi_dewan");
		$view->header = array("No Soalan","Nama Y.B","Perkara","Bentuk Soalan", "Sesi Dewan");
		$view->key = array("id","no_sol");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Soal Jawab Parlimen - Mengikut  Soalan Bertulis</div>
		<?php
		$view->out_bertulis();
		$ref="<a 

href=\"".$_SERVER['PHP_SELF']."?action=list&view=bybertulis&meet=$meet&sort=$sort&start=$start&page=";
}
	
	//by question  oral
	if($view_name == "bylisan"){
	
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$name = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a 

href='index.php?action=list&view=byyb&sort=desc&start=$start'><img src=\"../images/desc.gif\" 

border=\"0\"></a>":
		"<a text-decoration:none; 

href='index.php?action=list&view=byyb&sort=asc&start=$start'><img src=\"../images/asc.gif\" 

border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";	
		$sortAhli = $start<>""?" AND ahli_parlimen.nama LIKE '$start%'":"";
		
		if($isPegawai){
		$qry_all = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND 

parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi 

LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE 

'$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR 

YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		AND parlimen.bentuk_soalan like '%Lisan%'  $query_meet";
			
		$qry = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		CONVERT(no_soalan,DECIMAL) AS no_sol, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.sesi_dewan,
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND 

parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi 

LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE 

'$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR 

YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		AND parlimen.bentuk_soalan like '%Lisan%'  $query_meet
		ORDER BY tkh_bentang_jawapan desc , no_sol desc 
		LIMIT $offset,$pgRow";
				
		$view->query_all = $qry;		
		}
		elseif($isPengurusan )
		{
		$qry_all = "SELECT  parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND 

parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE 

'$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan') AND 

(YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		AND parlimen.bentuk_soalan like '%Lisan%'  $query_meet";
		
		$qry = "SELECT  parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		CONVERT(no_soalan,DECIMAL) AS no_sol, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.sesi_dewan,
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND 

parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE 

'$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan') AND 

(YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') 
		AND parlimen.bentuk_soalan like '%Lisan%'  $query_meet
		
		ORDER BY tkh_bentang_jawapan desc , no_sol desc 
		LIMIT $offset,$pgRow";
				//ORDER BY no_soalan ASC, parlimen.tkh_bentang_jawapan desc
		$view->query_all = $qry;
		
		}
		else {
		
		
		$qry_all = "SELECT parlimen.id FROM parlimen,ahli_parlimen 
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id
				AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR 

YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
				AND parlimen.bentuk_soalan like '%Lisan%'   $query_meet";
		$qry = "SELECT parlimen.id, DATE_FORMAT(tkh_bentang_jawapan,'%d/%m/%Y') AS 

Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,CONVERT(no_soalan,DECIMAL) AS no_sol,perkara,
				parlimen.sesi_dewan FROM parlimen,ahli_parlimen
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli
				AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR 

YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
				
				AND parlimen.bentuk_soalan like '%Lisan%'  $query_meet
				ORDER BY tkh_bentang_jawapan desc , no_sol desc  LIMIT $offset,$pgRow";
		//echo $qry;

		
		}
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("no_sol","nama_yb","perkara","bentuk_soalan","sesi_dewan");
		$view->header = array("Tarikh<br>Jawab<br>Soalan<br>Di Parlimen","No Soalan","Nama 

Y.B","Perkara","Bentuk Soalan","Sesi Dewan");
		$view->key = array("id","Tarikh");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Soal Jawab Parlimen - Mengikut  Soalan Lisan</div>
		<?php
		$view->out_lisan();
		$ref="<a 

href=\"".$_SERVER['PHP_SELF']."?action=list&view=bylisan&meet=$meet&sort=$sort&start=$start&page=";
	}
	// end of question oral

	if($view_name == "byno"){
	
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$name = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=byyb&sort=desc&start=$start'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a text-decoration:none; href='index.php?action=list&view=byyb&sort=asc&start=$start'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";	
		$sortAhli = $start<>""?" AND ahli_parlimen.nama LIKE '$start%'":"";
		
		if($isPegawai){
		$qry_all = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		$query_meet";
			
		$qry = "SELECT DISTINCT parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		CONVERT(no_soalan,DECIMAL) AS no_sol, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		 $query_meet
		
		ORDER BY no_sol ASC, parlimen.tkh_bentang_jawapan desc
		LIMIT $offset,$pgRow";
				
		$view->query_all = $qry;		
		}
		elseif($isPengurusan )
		{
		$qry_all = "SELECT  parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		no_soalan, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
		 $query_meet";
		
		$qry = "SELECT  parlimen.status AS status, 
		parlimen.id, 
		DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,
		ahli_parlimen.nama AS nama_yb, 
		bentuk_soalan,
		CONVERT(no_soalan,DECIMAL) AS no_sol, 
		parlimen.status, 
		parlimen.perkara, 
		parlimen.agensi
		FROM parlimen,ahli_parlimen,parlimen_agensi
		WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli AND parlimen.id=parlimen_agensi.parlimen_id 
		AND parlimen.status >1 AND  (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
		
		ORDER BY no_sol ASC
		LIMIT $offset,$pgRow";
				//ORDER BY no_soalan ASC, parlimen.tkh_bentang_jawapan desc
		$view->query_all = $qry;
		
		}
		else {
		
		
		$qry_all = "SELECT parlimen.id FROM parlimen,ahli_parlimen 
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id
				AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')
				
				 $query_meet";
		$qry = "SELECT parlimen.id, DATE_FORMAT(tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,CONVERT(no_soalan,DECIMAL) AS no_sol,perkara
				FROM parlimen,ahli_parlimen
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli
				AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY no_sol ASC, Tarikh desc LIMIT $offset,$pgRow";
		//echo $qry;

		
		}
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("Tarikh","nama_yb","perkara","bentuk_soalan");
		$view->header = array("No Soalan","Tarikh<br>Jawab<br>Soalan<br>Di Parlimen","Nama Y.B","Perkara","Bentuk Soalan");
		$view->key = array("id","no_sol");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Soal Jawab Parlimen - Mengikut Nombor Soalan</div>
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=byno&meet=$meet&sort=$sort&start=$start&page=";
	}



	//----------------------------------------------------------------------------------------------------------------------------------
	
if($view_name == "byagensi"){
		?> <div class="tajuk">Soal Jawab Parlimen - Mengikut Bahagian/Agensi</div>
		<br />
		<br /> <?php
		$view->col = array("no_soalan","perkara");
		$view->header = array("Tarikh","No Soalan","Perkara","Status"); 
		//echo "<table width=100% border=1>";
		//echo "<tr><th colspan=2>".implode('</th><th>',$this->header)."</th>";
		$cat = array("Bahagian Kementerian Kesihatan","Agensi");
		$agencies = array();
		$agencies_name = array();
		$i = 0;
	    
		foreach($cat AS $key)
		{		
			$re_agensi = mysql_query("SELECT id,nama FROM agensi WHERE kategori='$key' ORDER BY id") or die (mysql_error());
			while($row_agensi = mysql_fetch_array($re_agensi))
			{
			 	$agencies[] = $row_agensi['id'];
				$agencies_name[] = $row_agensi['nama'];
				$agen_id = $row_agensi['id'];
				$where .= $or."parlimen_agensi.agensi_id LIKE '$agen_id' OR parlimen_agensi.agensi_id LIKE '%+$agen_id' OR parlimen_agensi.agensi_id LIKE '$agen_id+%' OR parlimen_agensi.agensi_id LIKE '%+$agen_id+%'";
				$or = " OR ";
			}
		}	
		//echo $where;	
		$qry_all = "SELECT COUNT(*) AS total FROM parlimen_agensi WHERE $where";
		$view->query_all = $qry_all;
	//	echo $qry_all;
	   if($isPengurusan )
	   {
		foreach($agencies as $agensi_id) // loop avery agensi- retrive kabinet_agensi
		{
		
		$qry = "SELECT parlimen.id,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS tarikh,parlimen.perkara, parlimen_agensi.agensi_id,parlimen.no_soalan AS no_soalan
				FROM parlimen, parlimen_agensi
				WHERE (parlimen_agensi.agensi_id LIKE '$agensi_id' OR parlimen_agensi.agensi_id LIKE '%+$agensi_id' OR parlimen_agensi.agensi_id LIKE '$agensi_id+%' OR parlimen_agensi.agensi_id LIKE '%+$agensi_id+%') AND parlimen_agensi.parlimen_id = parlimen.id 
				AND (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan') 
				AND (parlimen.status!='44') 
				AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY parlimen.tkh_bentang_jawapan desc";
		       
			  // ORDER BY parlimen.tkh_bentang_jawapan desc LIMIT $offset,$pgRow";

		$view->query = $qry;
		
		$view->key = array("id","tarikh","no_soalan");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		$view->cat = "$agencies_name[$i]";
		
		//$view->testabc($agensi_id);
		$view->OutAgensi($agensi_id); //change to this by zaidi 11 mac 2011
		$i++;
	}	
	}
	else
	{
	foreach($agencies as $agensi_id) // loop avery agensi- retrive kabinet_agensi
		{
		
		$qry = "SELECT parlimen.id,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS tarikh,parlimen.perkara, parlimen_agensi.agensi_id,parlimen.no_soalan AS no_soalan
				FROM parlimen, parlimen_agensi
				WHERE (parlimen_agensi.agensi_id LIKE '$agensi_id' OR parlimen_agensi.agensi_id LIKE '%+$agensi_id' OR parlimen_agensi.agensi_id LIKE '$agensi_id+%' OR parlimen_agensi.agensi_id LIKE '%+$agensi_id+%') AND parlimen_agensi.parlimen_id = parlimen.id AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' AND (parlimen.status!='44')  OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY parlimen.tkh_bentang_jawapan desc";
		       //ORDER BY parlimen.tkh_bentang_jawapan desc LIMIT $offset,$pgRow";

		$view->query = $qry;
		
		$view->key = array("id","tarikh","no_soalan");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		$view->cat = "$agencies_name[$i]";
		
		$view->OutAgensi($agensi_id);
		
		$i++;
	}	
	
	
	}
	
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=byagensi&meet=$meet&page=";
	}
	
	//----------------------------------------------------------------------------------------------------------------------------------------------

	if($view_name == "bystatus"){
	
	?>
		<div class="tajuk">Soal Jawab Parlimen - Mengikut Status</div>
		<?php
		$tarikh = ($sortTkh=="asc")?"<img src=\"../images/altasc.gif\">Tarikh<a href='index.php?action=list&view=bystatus&sortTarikh=desc&sortWakil=$sortWakil'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bystatus&sortTarikh=asc&sortWakil=$sortWakil'><img src=\"../images/asc.gif\"></a>Tarikh<img src=\"../images/altdesc.gif\">";
		
		echo "<table width=100% border=1 style=\"border-collapse:collapse\">";
		//echo "<tr><th>".implode('</th><th>',"Tarikh<br>Jawab<br>Soalan<br>Di Parlimen","No Soalan","Nama Y.B","Perkara","Bentuk Soalan")."</th>";
		
		$view->header = array("Tarikh<br>Jawab<br>Soalan<br>Di Parlimen","No Soalan","Nama Y.B","Perkara","Bentuk Soalan");
	$status=array();
	$i=0;
		$re_status = mysql_query("SELECT status FROM status  ORDER BY id_sort ASC") or die (mysql_error());
			while($row_status = mysql_fetch_array($re_status))
			{
			 	$status[] = $row_status['status'];
			}
	
	foreach($status as $status_id) // loop avery agensi- retrive kabinet_agensi
		{
		//echo "$status_id";
		if($isPegawai){		
		$qry_all = "SELECT DISTINCT parlimen.status AS status, parlimen.id, parlimen.tkh_bentang_jawapan AS Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,no_soalan, parlimen.status, parlimen.perkara, parlimen.agensi,
				parlimen.penyemak AS penyemak,parlimen.penyemak2 AS penyemak2
				FROM parlimen,ahli_parlimen,parlimen_agensi
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
				AND parlimen.status ='$status_id' AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')  ";
				
		$qry = "SELECT DISTINCT parlimen.status AS status, parlimen.id, parlimen.tkh_bentang_jawapan AS Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,CONVERT(no_soalan,DECIMAL) AS no_soalan, parlimen.status, parlimen.perkara, parlimen.agensi,
				parlimen.penyemak AS penyemak,parlimen.penyemak2 AS penyemak2
				FROM parlimen,ahli_parlimen,parlimen_agensi
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
				AND parlimen.status ='$status_id' AND  (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY parlimen.tkh_bentang_jawapan DESC,no_soalan asc";
				//ORDER BY parlimen.tkh_bentang_jawapan DESC LIMIT $offset,$pgRow";
			
		}
		elseif($isPengurusan )
		{
		$qry_all = "SELECT DISTINCT parlimen.status AS status, parlimen.id, parlimen.tkh_bentang_jawapan AS Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,no_soalan, parlimen.status, parlimen.perkara,parlimen.penyemak AS penyemak, parlimen.agensi
				FROM parlimen,ahli_parlimen,parlimen_agensi
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
				AND parlimen.status ='$status_id' AND  (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan')  AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') ";
		
		$qry = "SELECT DISTINCT parlimen.status AS status, parlimen.id, parlimen.tkh_bentang_jawapan AS Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,CONVERT(no_soalan,DECIMAL) AS no_soalan,  parlimen.status, parlimen.perkara,parlimen.penyemak AS penyemak, parlimen.agensi
				FROM parlimen,ahli_parlimen,parlimen_agensi
				WHERE parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
				AND parlimen.status ='$status_id' AND  (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan')  AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY parlimen.tkh_bentang_jawapan DESC,no_soalan asc";
				//LIMIT $offset,$pgRow";
			
		
		}
		
		
		else {
		$qry_all = "SELECT parlimen.id FROM parlimen,ahli_parlimen,parlimen_agensi 
				WHERE parlimen.status ='$status_id' AND parlimen.ahli_dewan_id = ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id
				AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')  ";
		
		$qry = "SELECT parlimen.status AS status, parlimen.id, parlimen.tkh_bentang_jawapan AS Tarikh,ahli_parlimen.nama AS nama_yb, bentuk_soalan,CONVERT(no_soalan,DECIMAL) AS no_soalan, parlimen.status,perkara,
				parlimen.penyemak AS penyemak,parlimen.penyemak2 AS penyemak2
				FROM parlimen,ahli_parlimen
				WHERE parlimen.status ='$status_id' AND parlimen.ahli_dewan_id = ahli_parlimen.id AND  (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				ORDER BY parlimen.tkh_bentang_jawapan DESC,no_soalan asc";
				
				//ORDER BY parlimen.tkh_bentang_jawapan DESC LIMIT $offset,$pgRow"; //edit on 04042011
			//echo $qry;	
		
			
				}
				$view->query_all = $qry_all;	
		$view->query = $qry;
			$view->col = array("Tarikh","no_soalan","nama_yb","perkara","bentuk_soalan");
			$view->cat = "status";
			$view->key = array("id","status","penyemak");
		
		$view->catp1 = "penyemak";
		$view->catarray = array("penyemak");
		$view->catp2 = "penyemak2";
		
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		$view->OutStatus();
					$i++;	
			}

	
		

		
		
		
		
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bystatus&meet=$meet&sortTarikh=$sortTkh&sortWakil=$sortWakil&page=";
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
	
if($view_name == "bydrafjwpagen"){
		?> <div class="tajuk">Draf Soal Jawab Parlimen - Mengikut Bahagian/Agensi</div>
		<br />
		<br /> <?php
		$view->col = array("no_soalan","nama_yb","perkara","bentuk_soalan");
				//$view->col = array("no_soalan","nama_yb","perkara","bentuk_soalan");
		$view->header = array("Tarikh","No Soalan","Yb","Perkara","Bentuk Soalan"); 
		
		//$view->header = array("Tarikh","Perkara","Status"); 
		//echo "<table width=100% border=1>";
		//echo "<tr><th colspan=2>".implode('</th><th>',$this->header)."</th>";
		$cat = array("Bahagian Kementerian Kesihatan","Agensi");
		$agencies = array();
		$agencies_name = array();
		$i = 0;
	
		foreach($cat AS $key)
		{		
			$re_agensi = mysql_query("SELECT id,nama FROM agensi WHERE kategori='$key' ORDER BY id") or die (mysql_error());
			while($row_agensi = mysql_fetch_array($re_agensi))
			{
			 	$agencies[] = $row_agensi['id'];
				$agencies_name[] = $row_agensi['nama'];
				$agen_id = $row_agensi['id'];
				$where .= $or."parlimen_agensi.agensi_id LIKE '$agen_id' OR parlimen_agensi.agensi_id LIKE '%+$agen_id' OR parlimen_agensi.agensi_id LIKE '$agen_id+%' OR parlimen_agensi.agensi_id LIKE '%+$agen_id+%'";
				$or = " OR ";
			}
		}	
		//echo $where;	
		$qry_all = "SELECT COUNT(*) AS total FROM parlimen_agensi WHERE $where";
		$view->query_all = $qry_all;
	//	echo $qry_all;
		foreach($agencies as $agensi_id) // loop avery agensi- retrive kabinet_agensi
		{
		
		/*$qry = "SELECT parlimen.id,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS tarikh,parlimen.perkara, parlimen_agensi.agensi_id
				FROM parlimen, parlimen_agensi
				WHERE (parlimen_agensi.agensi_id LIKE '$agensi_id' OR parlimen_agensi.agensi_id LIKE '%+$agensi_id' OR parlimen_agensi.agensi_id LIKE '$agensi_id+%' OR parlimen_agensi.agensi_id LIKE '%+$agensi_id+%') AND parlimen_agensi.parlimen_id = parlimen.id AND YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' $query_meet
				ORDER BY parlimen.tkh_bentang_jawapan desc LIMIT $offset,$pgRow";*/
		$qry = "SELECT 	parlimen.id,tkh_bentang_jawapan AS tarikh,ahli_parlimen.nama AS nama_yb,bentuk_soalan,no_soalan,perkara
				FROM 
					parlimen,
					ahli_parlimen
				WHERE 
					parlimen.ahli_dewan_id = ahli_parlimen.id AND
					(parlimen.status = '4' OR parlimen.status = '5'  OR parlimen.status = '14') 
					and (parlimen.agensi LIKE '$agensi_id' OR parlimen.agensi LIKE '%+$agensi_id' OR parlimen.agensi LIKE '$agensi_id+%' OR parlimen.agensi LIKE '%+$agensi_id+%')
				ORDER BY 
					tkh_bentang_jawapan 
					
				LIMIT $offset,$pgRow";

          
            // echo $qry;

		$view->query = $qry;
		$view->key = array("id","tarikh");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		$view->cat = "$agencies_name[$i]";
		
		$view->OutAgensijwp($agensi_id);  
		
		$i++;
	}	
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bydrafjwpagen&meet=$meet&page=";
	}
	
	//----------------------------------------------------------------------------------------------------------------------------------------------

	if($view_name =='perhatianSoal' || $view_name ==''){ 
	//if($view_name =='perhatianSoal' ){


		if($isPegawai){
		    //pegawai perhubungan parlimen Bahagian, PPPB
			$qry_all = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.agensi, parlimen.no_soalan AS NoSoalan,parlimen.status AS status,parlimen.penyemak AS penyemak,parlimen.penyemak2 AS penyemak2, parlimen_agensi.status_pindaan,parlimen.kawasan_id As kawasanpar  
			FROM parlimen, ahli_parlimen, parlimen_agensi
		      WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
			 AND (parlimen.status = 21 OR parlimen.status=22 OR parlimen.status=15 OR parlimen.status=18 OR ( parlimen.status=12 AND (parlimen_agensi.status = 1 OR parlimen_agensi.status = 0))OR (parlimen.status = 10 AND parlimen_agensi.nama_pegawai='$nama_pegawai' AND parlimen_agensi.status_pindaan=0)) 
			AND (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')";
			
			
			
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.agensi, parlimen.no_soalan AS NoSoalan,parlimen.status AS status,parlimen.penyemak AS penyemak,parlimen.penyemak2 AS penyemak2, parlimen_agensi.status_pindaan,parlimen.kawasan_id As kawasanpar  
			FROM parlimen, ahli_parlimen, parlimen_agensi
		      WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
			 AND (parlimen.status = 21 OR parlimen.status=22 OR parlimen.status=15 OR parlimen.status=18 OR ( parlimen.status=12 AND (parlimen_agensi.status = 1 OR parlimen_agensi.status = 0))OR (parlimen.status = 10 AND parlimen_agensi.nama_pegawai='$nama_pegawai' AND parlimen_agensi.status_pindaan=0)) 
			AND (parlimen.agensi LIKE '%+$Pegawai_Agensi' OR parlimen.agensi LIKE '$Pegawai_Agensi+%' OR parlimen.agensi LIKE '%+$Pegawai_Agensi+%' OR parlimen.agensi LIKE '$Pegawai_Agensi') AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') GROUP BY parlimen.id ORDER BY tkh_bentang_jawapan desc LIMIT $offset,$pgRow";
			//AND (parlimen.status = 21 OR parlimen.status=22 OR ( parlimen.status=23 AND (parlimen_agensi.status = 1 OR parlimen_agensi.status = 0))OR (parlimen.status = 10 AND parlimen_agensi.nama_pegawai='$nama_pegawai' AND parlimen_agensi.status_pindaan=0)) asal 
			}
		elseif($isHEK)
		{ //take note this for kembali soalan
		   
		    $qry_all = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status,parlimen.kawasan_id As kawasanpar
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 1 OR parlimen.status = 3 OR parlimen.status=5 OR parlimen.status = 7 OR parlimen.status=8  OR parlimen.status=25)AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')"; 
		
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status,parlimen.kawasan_id As kawasanpar
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 1 OR parlimen.status = 3 OR parlimen.status=5 OR parlimen.status = 7 OR parlimen.status=8  OR parlimen.status=25) AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')ORDER BY tkh_bentang_jawapan desc LIMIT $offset,$pgRow"; 
			
			
			//WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 1 OR parlimen.status = 3 OR parlimen.status=5 OR parlimen.status = 7 OR parlimen.status=8 OR parlimen.status=23 OR parlimen.status=25) AND YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' ORDER BY tkh_bentang_jawapan desc";
	        //$ggg="cc";
			
			}
		elseif($isBoth)
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,  
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status, parlimen.penyemak  
			FROM parlimen, ahli_parlimen
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 6 OR parlimen.status = 4) AND (parlimen.penyemak LIKE '$Jawatan') 
			AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') ORDER BY tkh_bentang_jawapan desc";
	
		//elseif($isPengesahan)	
		elseif($isMK)	
		{
		  $qry_all = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status,parlimen.kawasan_id As kawasanpar
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 16 OR parlimen.status =19) AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')";
			
			 /*$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen.penyemak  
			FROM parlimen, ahli_parlimen
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 6) AND (parlimen.penyemak LIKE '$Jawatan') 
			AND YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' ORDER BY tkh_bentang_jawapan desc";   */ // asal pada 23 jan 2009 
	        $qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status,parlimen.kawasan_id As kawasanpar
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 16 OR parlimen.status =19) AND YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' ORDER BY tkh_bentang_jawapan desc LIMIT $offset,$pgRow";
	       //WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 1 OR parlimen.status = 3 OR parlimen.status=5 OR parlimen.status = 7 OR parlimen.status=8 OR parlimen.status=23) AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') ORDER BY tkh_bentang_jawapan desc"; asal
	    
		}
		elseif($isPengurusan)
		{
		   $qry_all= "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen.penyemak AS penyemak,parlimen.kawasan_id As kawasanpar
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 4 OR parlimen.status =14 OR parlimen.status =41 OR parlimen.status =42)  AND (parlimen.penyemak LIKE '$Jawatan') 
			AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')";
		
		
		
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, CONVERT(parlimen.no_soalan,DECIMAL) AS NoSoalan,parlimen.status AS status, parlimen.penyemak AS penyemak,parlimen.kawasan_id As kawasanpar
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 4 OR parlimen.status =14 OR parlimen.status =41 OR parlimen.status =42)  AND (parlimen.penyemak LIKE '$Jawatan') 
			AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') ORDER BY tkh_bentang_jawapan desc, NoSoalan asc  LIMIT $offset,$pgRow";
			/*elseif($isPengurusan)
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen.penyemak 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 4)  AND (parlimen.agensi LIKE '%$Pegawai_Agensi%') 
			AND YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' ORDER BY tkh_bentang_jawapan desc";
			echo "post".$Jawatan;*/
			}
			elseif($isKSP)
			{
			$qry_all = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen.penyemak,parlimen.kawasan_id As kawasanpar 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 13 OR parlimen.status =17 OR parlimen.status =43 )   
			AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')";
			
			
			
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen.penyemak,parlimen.kawasan_id As kawasanpar 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 13 OR parlimen.status =17 OR parlimen.status =43 )   
			AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') ORDER BY tkh_bentang_jawapan desc LIMIT $offset,$pgRow";
			}
			
			elseif($isSUSK_PTTK) //edit 21022011 untuk pptmk/susk
			{
			$qry_all = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen.penyemak,parlimen.kawasan_id As kawasanpar 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 9)   
			AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum')";
			
			
			
			$qry = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen.penyemak,parlimen.kawasan_id As kawasanpar 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 9)   
			AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') ORDER BY tkh_bentang_jawapan desc LIMIT $offset,$pgRow";
			}
			 
			 
		$result = mysql_query($qry,$conn) or die("");
		$rows = mysql_num_rows($result);
		//echo  $qry; 
		$view->query_all = $qry_all; 
		$view->query = $qry;
		$view->col = array("Tarikh","NoSoalan","AhliDewan","kawasanpar","perkara","BentukSoalan");		
		$view->header = array("Tarikh<br>Jawab<br>Soalan<br>Di Parlimen","No Soalan","Nama Y.B","Kawasan<br>Parlimen","Perkara","Bentuk Soalan");
		$view->cat = "status";
		$view->catp1 = "penyemak";
		$view->conn=$conn;
		$view->catp2 = "penyemak2";
		$view->key = array("id","status","penyemak"); 
		$view->ref = "index.php?action=details&id=";
		$view->query2($conn,$db_voffice);	
		?>
		<div class="tajuk">Senarai Untuk Tindakan - Soal Jawab Parlimen</div>
		<?php
		$view->outCat();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=perhatianSoal&page=";	
		
		if($rows == 0){
		echo "Tiada data untuk tindakan buat masa ini. Sila KLIK menu LAPORAN untuk membuat semakan.";
		}
	}

	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1); 
?>