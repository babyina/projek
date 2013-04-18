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
				
	if($view_name == "bynama"){		
	
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$name = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Nama YB<a href='index.php?action=list&view=bynama&sort=desc&start=$start'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a text-decoration:none; href='index.php?action=list&view=bynama&sort=asc&start=$start'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama YB<img src=\"../images/altdesc.gif\">";	
		$sortAhli = $start<>""?" AND ahli_parlimen.nama LIKE '$start%'":"";
		
		//$qry_all = "SELECT COUNT(*) AS total FROM ahli_parlimen 
		$qry_all = "SELECT ahli_parlimen.id FROM ahli_parlimen
		left join kawasan on kawasan_id=kawasan.id 
		left join parti on parti_id=parti.id
		WHERE ahli_parlimen.sesi_dewan = '1'";
		
		$qry = "SELECT ahli_parlimen.id AS id,ahli_parlimen.nama AS nama, ahli_parlimen.pangkat AS pangkat,
				kawasan.nama AS kawasan, parti.nama_pendek AS parti	FROM ahli_parlimen
				left join kawasan on kawasan_id=kawasan.id 
				left join parti on parti_id=parti.id 
				WHERE ahli_parlimen.sesi_dewan = '1' $sortAhli
				ORDER BY ahli_parlimen.nama $sort LIMIT $offset,$pgRow";
						
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("kawasan","parti");				
		$view->header = array($name,"Kawasan","Parti");
		$view->key = array("id","nama");
		$view->ref = "index.php?action=details&id=";
				
		$view->query2($conn,$db_voffice);
		?>
		
		<div style="font-family:Arial;font-size:8pt;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/> <b>Senarai Ahli Dewan Rakyat/Mengikut Nama</b><img src="../images/dot.gif"/>
		<br>
		<br>
		
		<?php
		$view->out3();
		//$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bynama&page=";
				
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bynama&sort=$sort&start=$start&page=";
		echo "<br/><div class=\"box\">";
		for($i=97;$i<=122;$i++){
		?>
			<a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list&view=bynama&sort=<?php echo $sort ?>&start=<?php echo chr($i) ?>"><?php echo chr($i-32) ?></a>&nbsp&nbsp;
		<?php
		}
		echo "<div>";	
				
	}
	
	/*if($view_name == "bykawasan"){		
		$qry_all = "SELECT ahli_parlimen.id FROM ahli_parlimen
		left join kawasan on kawasan_id=kawasan.id 
		left join parti on parti_id=parti.id
		WHERE ahli_parlimen.sesi_dewan = '1'";
		
		$qry = "select ahli_parlimen.id,ahli_parlimen.nama AS nama, kawasan.nama AS kawasan, parti.nama_pendek AS parti
		from ahli_parlimen
		left join kawasan on kawasan_id=kawasan.id 
		left join parti on parti_id=parti.id 
		WHERE ahli_parlimen.sesi_dewan = '1' LIMIT $offset,$pgRow";
										
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("nama","parti");				
		$view->header = array("Kawasan","Nama YB","Parti");
		$view->key = array("id","kawasan");
		$view->ref = "index.php?action=details&id=";
		
		$view->query2($conn,$db_voffice);
		?>
		
		<div style="font-family:Arial;font-size:8pt;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/> <b>Senarai Ahli Dewan Rakyat/Mengikut Kawasan</b><img src="../images/dot.gif"/>
		<br>
		<br>
		
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bykawasan&page=";
	}*/
	
	if($view_name == "bynama2"){		
	
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$name = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Nama YB<a href='index.php?action=list&view=bynama2&sort=desc&start=$start'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a text-decoration:none; href='index.php?action=list&view=bynama2&sort=asc&start=$start'><img src=\"../images/asc.gif\" border=\"0\"></a>Nama YB<img src=\"../images/altdesc.gif\">";	
		$sortAhli = $start<>""?" AND ahli_parlimen.nama LIKE '$start%'":"";
				
		$qry_all = "SELECT ahli_parlimen.id FROM ahli_parlimen WHERE ahli_parlimen.sesi_dewan = '2'";
				
		$qry = "select ahli_parlimen.id,ahli_parlimen.nama AS nama,ahli_parlimen.negeri AS negeri, parti.nama_pendek AS parti, negeri.nama AS negeri 	
				FROM ahli_parlimen
				LEFT JOIN parti on parti_id=parti.id 
				LEFT JOIN negeri on negeri=negeri.id 
				WHERE ahli_parlimen.sesi_dewan = '2' $sortAhli
				ORDER BY ahli_parlimen.nama $sort LIMIT $offset,$pgRow";
				//WHERE ahli_parlimen.sesi_dewan = '2' LIMIT $offset,$pgRow";
				
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("negeri","parti");				
		$view->header = array($name,"Negeri","Parti");
		$view->key = array("id","nama");
		$view->ref = "index.php?action=details2&id=";
		
		$view->query2($conn,$db_voffice);
		?>
		
		<div style="font-family:Arial;font-size:8pt;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/> <b>Senarai Ahli Dewan Negara/Mengikut Nama</b><img src="../images/dot.gif"/>
		<br>
		<br>
		
		<?php
		$view->out3();
		//$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list2&view=bynama2&page=";
		
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bynama2&sort=$sort&start=$start&page=";
		echo "<br/><div class=\"box\">";
		for($i=97;$i<=122;$i++){
		?>
			<a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list&view=bynama2&sort=<?php echo $sort ?>&start=<?php echo chr($i) ?>"><?php echo chr($i-32) ?></a>&nbsp&nbsp;
		<?php
		}
		echo "<div>";	
		
	}
	
	/*if($view_name == "bynegeri"){		
		$qry_all = "SELECT ahli_parlimen.id FROM ahli_parlimen WHERE ahli_parlimen.sesi_dewan = '2'";
				
		$qry = "select ahli_parlimen.id,ahli_parlimen.nama AS nama,ahli_parlimen.negeri AS negeri FROM ahli_parlimen
				WHERE ahli_parlimen.sesi_dewan = '2' LIMIT $offset,$pgRow";
				
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("nama");				
		$view->header = array("Negeri","Nama YB");
		$view->key = array("id","negeri");
		$view->ref = "index.php?action=details2&id=";
		
		$view->query2($conn,$db_voffice);
		?>
		
		<div style="font-family:Arial;font-size:8pt;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/> <b>Senarai Ahli Dewan Rakyat/Mengikut Negeri</b><img src="../images/dot.gif"/>
		<br>
		<br>
		
		<?php
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list2&view=bynegeri&page=";
				
	}*/
	
	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
?>