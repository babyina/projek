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
	
	if($view_name == "bykategori" || $view_name == ""){
		/*
		$qry_all = "SELECT COUNT(*) AS total FROM konfigurasi";
					
		$qry = "SELECT konfigurasi.id, konfigurasi.kategori, konfigurasi.kod,konfigurasi.butiran
				FROM konfigurasi LIMIT $offset,$pgRow";

		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("kod","butiran");
		$view->header = array("Kategori","Kod","Butiran");
		$view->key = array("id","kategori");
		$view->ref = "index.php?action=details&id=";

		$view->query($conn,$db_voffice);
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bydate&page=";
		*/
		include ("view_byKategori.php");
	}

	if($view_name == "bybutiran"){
		$qry_all = "SELECT COUNT(*) AS total FROM konfigurasi";
					
		$qry = "SELECT konfigurasi.id, konfigurasi.kategori, konfigurasi.kod,konfigurasi.butiran
				FROM konfigurasi LIMIT $offset,$pgRow";

		$view->query_all = $qry_all;
		$view->query = $qry;
		$view->col = array("kategori","kod");
		$view->header = array("Butiran","Kategori","Kod");
		$view->key = array("id","butiran");
		$view->ref = "index.php?action=details&id=";

		$view->query($conn,$db_voffice);
		$view->out();
		$ref="<a href=\"".$_SERVER['PHP_SELF']."?action=list&view=bydate&page=";
	}

	$view->Paging($pgRow,$ref,isset($_GET['page'])?$_GET['page']:1);
?>