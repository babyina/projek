<?php
	include("../view.php");

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
		$sortKawasan = ($_GET['sortKawasan']=='desc')?"desc":"asc";	

		$tarikh = ($sortTkh=="asc")?"<img src=\"../images/altasc.gif\">Tarikh<a href='index.php?action=list&view=bydate&sortTarikh=desc&sortWakil=$sortWakil&sortKawasan=$sortKawasan'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bydate&sortTarikh=asc&sortWakil=$sortWakil&sortKawasan=$sortKawasan'><img src=\"../images/asc.gif\" border=\"0\"></a>Tarikh<img src=\"../images/altdesc.gif\">";
	
		$yb = ($sortWakil=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=desc&sortKawasan=$sortKawasan'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=asc&sortKawasan=$sortKawasan'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";

		$kawasan = ($sortKawasan=="asc")?"<img src=\"../images/altasc.gif\">Kawasan<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=$sortWakil&sortKawasan=desc'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=$sortWakil&sortKawasan=asc'><img src=\"../images/asc.gif\" border=\"0\"></a>Kawasan Parlimen<img src=\"../images/altdesc.gif\">";
	
		$qry_all = "SELECT COUNT(*) AS total FROM parlimen,kawasan,ahli_parlimen WHERE kawasan.id = parlimen.kawasan_id AND parlimen.ahli_dewan_id = ahli_parlimen.id";
		$qry = "SELECT parlimen.id, tkh_mula_bersidang,ahli_parlimen.nama AS nama_yb, kawasan.nama as kawasan,bentuk_soalan,no_soalan
				FROM parlimen,kawasan,ahli_parlimen
				WHERE kawasan.id = parlimen.kawasan_id AND parlimen.ahli_dewan_id = ahli_parlimen.id
				ORDER BY tkh_mula_bersidang $sortTkh,nama_yb $sortWakil, kawasan $sortKawasan LIMIT $offset,$pgRow";

		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("nama_yb","kawasan","bentuk_soalan","no_soalan");
		$view->header = array($tarikh,$yb,$kawasan,"Bentuk Soalan","No Soalan");
		$view->key = array("id","tkh_mula_bersidang");
		$view->ref = "index.php?action=details&id=";

		$view->query($conn,$db_voffice);
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=$sortWakil&page=";
	}

	//----------------------------------------------------------------------------------------------------------------------------------


	if($view_name == "byyb"){
	
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$nama = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Nama Y.B<a href='index.php?action=list&view=byyb&sort=desc&start=$start'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a text-decoration:none; href='index.php?action=list&view=byyb&sort=asc&start=$start'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama Y.B<img src=\"../images/altdesc.gif\">";	
		$sortAhli = $start<>""?" AND ahli_parlimen.nama LIKE '$start%'":"";
		$qry_all = "SELECT COUNT(*) AS total FROM parlimen,kawasan,ahli_parlimen WHERE kawasan.id = parlimen.kawasan_id AND parlimen.ahli_dewan_id = ahli_parlimen.id";
		$qry = "SELECT parlimen.id, tkh_mula_bersidang,ahli_parlimen.nama AS nama_yb, kawasan.nama as kawasan,bentuk_soalan,no_soalan
				FROM parlimen,kawasan,ahli_parlimen
				WHERE kawasan.id = parlimen.kawasan_id AND parlimen.ahli_dewan_id = ahli_parlimen.id $sortAhli
				ORDER BY ahli_parlimen.nama $sort LIMIT $offset,$pgRow";
		//echo $qry;

		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("tkh_mula_bersidang","kawasan","bentuk_soalan","no_soalan");
		$view->header = array($nama,"Tarikh","Kawasan","Bentuk Soalan","No Soalan");
		$view->key = array("id","nama_yb");
		$view->ref = "index.php?action=details&id=";

		$view->query($conn,$db_voffice);
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=byyb&sort=$sort&start=$start&page=";
		echo "<br/><div class=\"box\">";
		for($i=97;$i<=122;$i++){
		?>
			<a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list&view=byyb&sort=<?php echo $sort ?>&start=<?php echo chr($i) ?>"><?php echo chr($i-32) ?></a>&nbsp&nbsp;
		<?php
		}
		echo "<div>";	}

	//----------------------------------------------------------------------------------------------------------------------------------


	if($view_name == "bystatus"){
		$tarikh = ($sortTkh=="asc")?"<img src=\"../images/altasc.gif\">Tarikh<a href='index.php?action=list&view=bystatus&sortTarikh=desc&sortWakil=$sortWakil'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a href='index.php?action=list&view=bystatus&sortTarikh=asc&sortWakil=$sortWakil'><img src=\"../images/asc.gif\"></a>Tarikh<img src=\"../images/altdesc.gif\">";
	
		$qry_all = "SELECT COUNT(*) AS total FROM parlimen,kawasan,ahli_parlimen WHERE kawasan.id = parlimen.kawasan_id AND parlimen.ahli_dewan_id = ahli_parlimen.id";
		$qry = "SELECT parlimen.status AS status, parlimen.id, tkh_mula_bersidang,ahli_parlimen.nama AS nama_yb, kawasan.nama as kawasan,bentuk_soalan,no_soalan, parlimen.status
				FROM parlimen,kawasan,ahli_parlimen
				WHERE kawasan.id = parlimen.kawasan_id AND parlimen.ahli_dewan_id = ahli_parlimen.id
				ORDER BY parlimen.status,tkh_mula_bersidang $sortTkh LIMIT $offset,$pgRow";

		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("nama_yb","tkh_mula_bersidang","kawasan","bentuk_soalan","no_soalan");
		$view->header = array("Status","Nama Y.B","Tarikh","Kawasan","Bentuk Soalan","No Soalan");
		$view->cat = "status";
		$view->key = array("id","status");
		$view->ref = "index.php?action=details&id=";

		$view->query($conn,$db_voffice);
		//$doc_status[4] = "Untuk Tindakan Pengurusan";
		//$doc_status[9] = "Jawapan Akhir";
		$view->OutCat();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bystatus&sortTarikh=$sortTkh&sortWakil=$sortWakil&page=";
	}


	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
?>