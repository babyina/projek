<?php

$action = $_GET['action'];

//default view
if($action == ''){
	include("LapView.php");
}

//Section utk Delete Rekod
if($_POST['deleteDoc']){
	include("Delete.php");
}

//Section for Jadual Cuti
elseif($_POST['SimpanCuti']){
	include("CutiSimpan.php");
}
elseif($_POST['EditCuti']){
	include("CutiEdit.php");
}
elseif($action == 'newdocCuti'){
	include("CutiEdit.php");
}
elseif($action == 'listCuti'){
	include("CutiView.php");
}
elseif($action == 'detailsCuti'){
	include("CutiDetails.php");
}

//Section for Jadual Pegawai Bertugas
elseif($_POST['KalSimpan']){
	include("KalSimpan.php");
}
elseif($_POST['KalEdit']){
	include("KalEdit.php");
}

elseif($action == 'newdocKal'){
	include("KalEdit.php");
}elseif($action == 'listKal'){
	include("KalView.php");
}elseif($action == 'detailsKal'){
	include("KalDetails.php");
}

//Section for Laporan Dewan
elseif($_POST['simpanLap']){
	include("LapSimpan.php");
}elseif($_POST['pegawaiNama']){
	include("LapEdit.php");
}elseif($action == 'newdocLap'){
	include("LapEdit.php");
}elseif($action == 'editLap'){
	include("LapEdit.php");
}elseif($action == 'detailsLap'){
	include("LapDetails.php");
}elseif($action == 'listLap'){
	include("LapView.php");
}

?>