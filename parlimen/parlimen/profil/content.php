<?php

$action = $_GET['action'];

if($_POST['Simpan']){
	include("simpan.php");
}elseif($_POST['Edit'] || $_POST['Refresh']){
	include("editDoc.php");
}

elseif($_POST['Simpan2']){
	include("simpan2.php");
}elseif($_POST['Edit2']){
	include("editDoc2.php");
}elseif($_POST['deleteDoc']){
	include("delete.php");
}

elseif($action == 'newdoc'){
	include("editDoc.php");
}elseif($action == 'list'){
	include("viewProfil.php");
}elseif($action == 'details'){
	include("detail.php");
}

elseif($action == 'newdoc2'){
	include("editDoc2.php");
}elseif($action == 'list2'){
	include("viewProfil.php");
}elseif($action == 'details2'){
	include("detail2.php");
}

?>