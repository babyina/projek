<?php

$action = $_GET['action'];

if($_POST['Simpan']){
	include("simpan.php");
}elseif($_POST['Edit']){
	include("editAgensi.php");
}elseif($_POST['Hapus']){
	include("hapus.php");
}

elseif($action == 'newdoc'){
	include("editAgensi.php");
}elseif($action == 'list' || $action == ''){
	include("viewKatakunci.php");
}elseif($action == 'details'){
	include("detail.php");
}elseif($action == 'deleteDoc'){
	include("hapus.php");
}



?>