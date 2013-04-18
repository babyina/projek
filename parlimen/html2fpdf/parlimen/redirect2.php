<?php
session_start();
if($_POST['CarianLengkap']){		
		$i=-1;
		if($_POST['SesiDewan']<>'semua')
			$where[$i++] = "SesiDewan='".$_POST['SesiDewan']."'";
		if($_POST['Parlimen']<>'semua')
			$where[$i++] = "Parlimen='".$_POST['Parlimen']."'";
		if($_POST['Penggal']<>'semua')
			$where[$i++] = "Penggal='".$_POST['Penggal']."'";
		if($_POST['Mesyuarat']<>'semua')
			$where[$i++] = "Mesyuarat='".$_POST['Mesyuarat']."'";
		if($_POST['BentukSoalan']<>'semua')
			$where[$i++] = "BentukSoalan='".$_POST['BentukSoalan']."'";
		if($_POST['Tahun']<>"")
			$where[$i++] = "YEAR(TkhMulaBersidang)='".$_POST['Tahun']."'";
		if($_POST['KawasanParlimen']<>'semua')
			$where[$i++] = "KawasanParlimen='".$_POST['KawasanParlimen']."'";
		if($_POST['Perkara']<>"")
			$where[$i++] = "Perkara LIKE '%".$_POST['Perkara']."%'";
		
		$where_statement = ($i==-1)?"":"WHERE ".implode(" AND ",$where);
		$qry = "SELECT id,SesiDewan,Perkara,Penggal,Mesyuarat,DATE_FORMAT(TkhMulaBersidang,'%d/%m/%Y') AS TkhMulaBersidang,DATE_FORMAT(TkhAkhirBersidang,'%d/%m/%Y') AS TkhAkhirBersidang,DATE_FORMAT(TkhBentang,'%d/%m/%Y') AS TkhBentang,NoSoalan,BentukSoalan,KawasanParlimen,AhliDewan,Parti FROM parlimen $where_statement ";
		$_SESSION['sql'] = $qry;	
		$_SESSION['cols'] = $_POST['column'];
		
}
$url = "Location:index.php?mode=ResultCarian";
header($url);
?>