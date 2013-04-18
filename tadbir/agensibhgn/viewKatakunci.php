<?php
	include("../view.php");

	$pgNum = 1;
	$pgRow = 25;
	
	if(isset($_GET['page'])){
		$pgNum = $_GET['page'];
	}else
		$pgNum = 1;
	$offset =($pgNum -1)*$pgRow;
	$isAdmin= checkOfficer($_SESSION['userid'],1,$conn);
	
	$extra_col = "";
	$extra_header = "";
	
	if($isAdmin){
		$extra_header = ($sys_acl==2)?"Hapus?":"";
	}
	$view_name = $_GET['view'];
	$view = new View();
	
	if($view_name == "bykategori" || $view_name == ""){
		/*
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$kategori = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Kategori<a href='index.php?action=list&view=bykategori&sort=desc&start=$start'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a text-decoration:none; href='index.php?action=list&view=bykategori&sort=asc&start=$start'><img src=\"../images/asc.gif\" border=\"0\"></a>Kategori<img src=\"../images/altdesc.gif\">";	
		$sortKategori = $start<>""?" WHERE konfigurasi.kategori LIKE '$start%'":"";
		
		$qry_all = "SELECT konfigurasi.id FROM konfigurasi";
					
		$qry = "SELECT konfigurasi.id, konfigurasi.kategori, konfigurasi.kod,konfigurasi.butiran
				FROM konfigurasi $sortKategori
				ORDER BY konfigurasi.kategori $sort LIMIT $offset,$pgRow";
				
		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("kod","butiran");
		$view->header = array($kategori,"Kod","Butiran");
		$view->key = array("id","kategori");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		?>
		
		<div style="font-family:Arial;font-size:8pt;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/> <b>Senarai Katakunci/Mengikut Kategori</b><img src="../images/dot.gif"/>
		<br>		
		<?php
		$view->outDel($del,$sys_acl);
						
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bykategori&sort=$sort&start=$start&page=";
		echo "<br/><div class=\"box\">";
		for($i=97;$i<=122;$i++){
		?>
		
		<a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list&view=bykategori&sort=<?php echo $sort ?>&start=<?php echo chr($i) ?>"><?php echo chr($i-32) ?></a>&nbsp&nbsp;
		
		<?php
		}
		echo "<div>";
		*/
		include ("view_byKategori.php");
	}

	if($view_name == "bybutiran"){
	
		$sort = isset($_GET['sort'])?$_GET['sort']:'asc';
		$start = isset($_GET['start'])?$_GET['start']:"";
		$butiran = ($sort=="asc")?"<img src=\"../images/altasc.gif\">Butiran<a href='index.php?action=list&view=bybutiran&sort=desc&start=$start'><img src=\"../images/desc.gif\" border=\"0\"></a>":
		"<a text-decoration:none; href='index.php?action=list&view=bybutiran&sort=asc&start=$start'><img src=\"../images/asc.gif\" border=\"0\"></a>Butiran<img src=\"../images/altdesc.gif\">";	
		$sortButiran = $start<>""?" Where konfigurasi.butiran LIKE '$start%'":"";
		
		$qry_all = "SELECT konfigurasi.id FROM konfigurasi";
					
		$qry = "SELECT konfigurasi.id, konfigurasi.kategori, konfigurasi.kod,konfigurasi.butiran
				FROM konfigurasi $sortButiran
				ORDER BY konfigurasi.butiran $sort LIMIT $offset,$pgRow";

		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("kategori","kod",);
		$view->header = array($butiran,"Kategori","Kod");
		$view->key = array("id","butiran");
		$view->ref = "index.php?action=details&id=";

		$view->query2($conn,$db_voffice);
		
		?>
		
		<div style="font-family:Arial;font-size:8pt;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/> <b>Senarai Katakunci/Mengikut Butiran</b><img src="../images/dot.gif"/>
		<br>
		<br>
		
		<?php
		$view->outDel($del,$sys_acl);
						
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bybutiran&sort=$sort&start=$start&page=";
		echo "<br/><div class=\"box\">";
		for($i=97;$i<=122;$i++){
		?>
		
		<a href="<?php echo $_SERVER['PHP_SELF'] ?>?action=list&view=bybutiran&sort=<?php echo $sort ?>&start=<?php echo chr($i) ?>"><?php echo chr($i-32) ?></a>&nbsp&nbsp;
		
		<?php
		}
		echo "<div>";	
	}

	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
?>