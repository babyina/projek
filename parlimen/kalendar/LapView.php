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
	
	if($view_name == "bynama" || $view_name == ""){
		$qry_all = "Select kal_lapdwn.SesiDewan, kal_lapdwn.TarikhSidang, kal_lapdwn.PgwNama, kal_lapdwn.PgwBhg, kal_lapdwn.MasaTangguh From kal_lapdwn Order By kal_lapdwn.SesiDewan Desc, kal_lapdwn.TarikhSidang Asc, kal_lapdwn.PgwNama Asc";
		$qry = "Select kal_lapdwn.Kal_lapdwn_id, kal_lapdwn.SesiDewan, kal_lapdwn.PgwNama, kal_lapdwn.PgwBhg, kal_lapdwn.MasaTangguh,
				DATE_FORMAT(kal_lapdwn.TarikhSidang,'%d/%m/%Y') AS TarikhSidang				
				From kal_lapdwn 
				ORDER BY kal_lapdwn.PgwNama Asc , kal_lapdwn.TarikhSidang desc
				LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("TarikhSidang","PgwBhg","MasaTangguh");
		$view->header = array("Nama Pegawai","Tarikh","Bahagian","Masa Tangguh");
		$view->key = array("Kal_lapdwn_id","PgwNama");
		$view->ref = "index.php?action=editLap&id=";
		
		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Laporan Persidangan - Mengikut Nama</div>
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bysesi&page=";
	}
	
	if($view_name == "byDewanRakyat"){				
		$qry_all = "SELECT kal_lapdwn.SesiDewan 
					FROM kal_lapdwn ";
		$qry = "SELECT 
					kal_lapdwn.Kal_lapdwn_id, 
					kal_lapdwn.SesiDewan, 
					kal_lapdwn.PgwNama, 
					kal_lapdwn.PgwBhg, 
					kal_lapdwn.MasaTangguh,
					DATE_FORMAT(kal_lapdwn.TarikhSidang,'%d/%m/%Y') AS TarikhSidang				
				FROM kal_lapdwn 
				WHERE kal_lapdwn.SesiDewan='1'
				ORDER BY 
					kal_lapdwn.TarikhSidang desc, 
					kal_lapdwn.PgwNama Asc 
				LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("PgwNama","PgwBhg","MasaTangguh");
		$view->header = array("Tarikh","Nama Pegawai","Bahagian","Masa Tangguh");
		$view->key = array("Kal_lapdwn_id","TarikhSidang");
		$view->ref = "index.php?action=editLap&id=";
		
		$view->query2($conn,$db_voffice);
		?>
		
		<div class="tajuk">Laporan Persidangan - Sesi Dewan Rakyat</div>
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bysesi&page=";
	}
	
	if($view_name == "byDewanNegara"){				
		$qry_all = "SELECT kal_lapdwn.SesiDewan 
					FROM kal_lapdwn ";
		$qry = "SELECT 
					kal_lapdwn.Kal_lapdwn_id, 
					kal_lapdwn.SesiDewan, 
					kal_lapdwn.PgwNama, 
					kal_lapdwn.PgwBhg, 
					kal_lapdwn.MasaTangguh,
					DATE_FORMAT(kal_lapdwn.TarikhSidang,'%d/%m/%Y') AS TarikhSidang				
				FROM kal_lapdwn 
				WHERE kal_lapdwn.SesiDewan='2'
				ORDER BY 
					kal_lapdwn.TarikhSidang desc, 
					kal_lapdwn.PgwNama Asc 
				LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("PgwNama","PgwBhg","MasaTangguh");
		$view->header = array("Tarikh","Nama Pegawai","Bahagian","Masa Tangguh");
		$view->key = array("Kal_lapdwn_id","TarikhSidang");
		$view->ref = "index.php?action=editLap&id=";
		
		$view->query2($conn,$db_voffice);
		?>
		<div class="tajuk">Laporan Persidangan - Sesi Dewan Negara</div>
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bysesi&page=";
	}
	
	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
?>