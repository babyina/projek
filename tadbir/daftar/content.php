<?php

$mode	= $_GET['mode'];
$action = $_GET['action'];

switch ($action){
	case "modul":include("modul.php");break; 
}
if($_POST['SimpanLDAP']){
	include("simpan_sop.php");
	exit; 
	}
	if($_POST['SimpanAgensi']){
	include("simpan_sop.php"); 
	exit; 
	}
if($_POST['Simpan&Daftar']){
	include("simpan.php");
}elseif($_POST['Simpan']){
	include("simpan.php");
}elseif($_POST['Edit']){
	include("editDaftar.php");
}elseif($_POST['Hantar']){
	include("simpan.php");
}elseif($_POST['DeleteUser']){
	include("hapus.php");
}
elseif($action == ''){
	include("view.php");
}elseif($action == 'search'){
	include("search.php");
}elseif($action == 'newdoc'){
	include("editDaftar.php");
}elseif($action == 'list'){
	include("view.php");
}elseif($action == 'details'){
	include("detail.php");
}elseif($action == 'tolak'){
	include("reject.php");
}elseif($action == "sah"){
	include("sah.php");
}elseif($action == "check"){
	include("check.php");
}
elseif($action == 'newdoc3'){
include("editDaftartreasury.php"); //add by zaidi for user category
	}
?>