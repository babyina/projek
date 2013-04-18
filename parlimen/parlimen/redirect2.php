<?php
session_start();
if($_POST['KeputusanCarian']){		
		$i=-1;
		if($_POST['SesiDewan']<>'semua')
			$where[$i++] = "sesi_dewan='".$_POST['SesiDewan']."'";
		if($_POST['Parlimen']<>'semua')
			$where[$i++] = "parlimen='".$_POST['Parlimen']."'";
		if($_POST['Penggal']<>'semua')
			$where[$i++] = "penggal='".$_POST['Penggal']."'";
		if($_POST['Mesyuarat']<>'semua')
			$where[$i++] = "mesyuarat='".$_POST['Mesyuarat']."'";
		if($_POST['BentukSoalan']<>'semua')
			$where[$i++] = "bentuk_soalan='".$_POST['BentukSoalan']."'";
		if($_POST['Tahun']<>"")
			$where[$i++] = "YEAR(tkh_mula_bersidang)='".$_POST['Tahun']."'";
		if($_POST['KawasanParlimen']<>'semua')
			$where[$i++] = "kawasan_id='".$_POST['KawasanParlimen']."'";
		if($_POST['Perkara']<>"")
			$where[$i++] = "perkara LIKE '%".$_POST['Perkara']."%'";
		
		$where_statement = ($i==-1)?"":"WHERE ".implode(" AND ",$where);
		$qry = "SELECT id,sesi_dewan,perkara,penggal,mesyuarat,DATE_FORMAT(tkh_mula_bersidang,'%d/%m/%Y') AS tkh_mula_bersidang,DATE_FORMAT(tkh_akhir_bersidang,'%d/%m/%Y') AS tkh_akhir_bersidang,DATE_FORMAT(tkh_bentang_jawapan,'%d/%m/%Y') AS tkh_bentang_jawapan,no_soalan,bentuk_soalan,kawasan_id,ahli_dewan_id,parti_id FROM parlimen $where_statement ";
		$_SESSION['sql'] = $qry;	
		$_SESSION['cols'] = $_POST['column'];
		
}
$url = "Location:index.php?action=KeputusanCarian";
header($url);
?>