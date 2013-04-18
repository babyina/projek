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
	$view = new View();
	if($view_name == "bytarikh"){
		
		$qry_all = "SELECT kal_cuti.id,DATE_FORMAT(kal_cuti.tarikh,'%d/%m/%Y') AS tarikh,kal_cuti.hari,kal_cuti.cuti From kal_cuti";
		$qry = "SELECT 
					kal_cuti.id,
					DATE_FORMAT(kal_cuti.tarikh,'%d/%m/%Y') AS tarikh,
					kal_cuti.hari,
					kal_cuti.cuti 
				FROM kal_cuti 
				ORDER BY kal_cuti.tarikh ASC
				LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("hari","cuti");				
		$view->header = array("Tarikh","Hari","Cuti");
		$view->key = array("id","tarikh");
		$view->ref = "index.php?action=detailsCuti&id=";
		
		$view->query2($conn,$db_voffice);
		?>		
		<div class="tajuk">Senarai Cuti - Mengikut Tarikh</div>		
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=listCuti&view=bytarikh&page=";
		//$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bydate&sortTarikh=$sortTkh&sortWakil=$sortWakil&page=";
	}
	
	if($view_name == "bycuti"){		
		
		$qry_all = "SELECT kal_cuti.id,DATE_FORMAT(kal_cuti.tarikh,'%d/%m/%Y') AS tarikh,kal_cuti.hari,kal_cuti.cuti From kal_cuti";
		$qry = "SELECT 
					kal_cuti.id,
					DATE_FORMAT(kal_cuti.tarikh,'%d/%m/%Y') AS tarikh,
					kal_cuti.hari,
					kal_cuti.cuti 
				From kal_cuti 
				ORDER BY kal_cuti.cuti ASC
				LIMIT $offset,$pgRow";
										
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("tarikh","hari");				
		$view->header = array("Cuti","Tarikh","Hari");
		$view->key = array("id","cuti");
		$view->ref = "index.php?action=detailsCuti&id=";
		
		$view->query2($conn,$db_voffice);
		?>
		
		<div class="tajuk">Senarai Cuti/Mengikut Nama Cuti</div>
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=listCuti&view=bycuti&page=";
	}
	
	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
?>