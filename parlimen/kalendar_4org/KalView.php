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

	if($view_name == "byrakyat"){
		$qry_all = "SELECT m.Kal_mesyuarat_id,m.Parlimen,m.Penggal,m.Sesi,m.Mesyuarat FROM kal_mesyuarat AS m";
		$qry = "SELECT m.Kal_mesyuarat_id,m.Parlimen,m.Penggal,m.Sesi,m.Mesyuarat FROM kal_mesyuarat AS m WHERE Sesi='1' LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("Penggal","Mesyuarat");
		$view->header = array("Parlimen","Penggal","Mesyuarat");
		$view->key = array("Kal_mesyuarat_id","Parlimen");
		$view->ref = "index.php?action=detailsKal&id=";
		
		$view->query2($conn,$db_voffice);
		?>
		
		<div class="tajuk">Kalendar - Dewan Rakyat</div>
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=byrakyat&page=";
	}
	
		if($view_name == "bynegara"){		
		
		$qry_all = "SELECT m.Kal_mesyuarat_id,m.Parlimen,m.Penggal,m.Sesi,m.Mesyuarat FROM kal_mesyuarat AS m";
		$qry = "SELECT m.Kal_mesyuarat_id,m.Parlimen,m.Penggal,m.Sesi,m.Mesyuarat FROM kal_mesyuarat AS m LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("Penggal","Mesyuarat");
		$view->header = array("Parlimen","Penggal","Mesyuarat");
		$view->key = array("Kal_mesyuarat_id","Parlimen");
		$view->ref = "index.php?action=detailsKal&id=";
		
		$view->query2($conn,$db_voffice);
		?>
		
		<div class="tajuk">Senarai Takwim</div>
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bynegara&page=";
	}
	
	if($view_name == "bytarikh"){		
		
		$qry_all = "SELECT kal_cuti.id,kal_cuti.tarikh,kal_cuti.hari,kal_cuti.cuti From kal_cuti";
		$qry = "SELECT kal_cuti.id,kal_cuti.tarikh,kal_cuti.hari,kal_cuti.cuti From kal_cuti LIMIT $offset,$pgRow";
		
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("hari","cuti");				
		$view->header = array("Tarikh","Hari","Cuti");
		$view->key = array("id","tarikh");
		$view->ref = "index.php?action=details&id=";
		
		$view->query2($conn,$db_voffice);
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bysesi&page=";
	}
	
	if($view_name == "bysesi2"){		
		$qry_all = "SELECT COUNT(*) AS total FROM ahli_parlimen
		left join kawasan on kawasan_id=kawasan.id 
		left join parti on parti_id=parti.id";
		
		$qry = "select ahli_parlimen.id,ahli_parlimen.nama AS nama, kawasan.nama AS kawasan, parti.nama_pendek AS parti
		from ahli_parlimen
		left join kawasan on kawasan_id=kawasan.id 
		left join parti on parti_id=parti.id LIMIT $offset,$pgRow";
		//Inner Join kawasan ON ahli_parlimen.kawasan_id = kawasan.nama
		//Inner Join parti ON ahli_parlimen.parti_id = parti.nama_pendek LIMIT $offset,$pgRow";
								
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("nama","parti");				
		$view->header = array("Kawasan","Nama Y.B","Parti");
		$view->key = array("id","kawasan");
		$view->ref = "index.php?action=details&id=";
		
		$view->query2($conn,$db_voffice);
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bykawasan&page=";
	}
	
	if($view_name == "bynama"){		
		$qry_all = "SELECT COUNT(*) AS total FROM ahli_parlimen
		left join kawasan on kawasan_id=kawasan.id 
		left join parti on parti_id=parti.id";
		
		$qry = "select ahli_parlimen.id,ahli_parlimen.nama AS nama, kawasan.nama AS kawasan, parti.nama_pendek AS parti
		from ahli_parlimen
		left join kawasan on kawasan_id=kawasan.id 
		left join parti on parti_id=parti.id LIMIT $offset,$pgRow";
				
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("kawasan","parti");				
		$view->header = array("Nama Y.B","Negeri","Parti");
		$view->key = array("id","nama");
		$view->ref = "index.php?action=details2&id=";
		
		$view->query2($conn,$db_voffice);
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list2&view=bynama2&page=";
	}
	
	if($view_name == "bynegeri"){		
		$qry_all = "SELECT COUNT(*) AS total FROM ahli_parlimen
		left join kawasan on kawasan_id=kawasan.id 
		left join parti on parti_id=parti.id";
		
		$qry = "select ahli_parlimen.id,ahli_parlimen.nama AS nama, kawasan.nama AS kawasan, parti.nama_pendek AS parti
		from ahli_parlimen
		left join kawasan on kawasan_id=kawasan.id 
		left join parti on parti_id=parti.id LIMIT $offset,$pgRow";
				
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("nama","parti");				
		$view->header = array("Negeri","Nama Y.B","Parti");
		$view->key = array("id","kawasan");
		$view->ref = "index.php?action=details&id=";
		
		$view->query2($conn,$db_voffice);
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list2&view=bynegeri&page=";
	}
	
	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
?>