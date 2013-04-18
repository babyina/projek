<?php
#part of index.php

$action = $_GET['action'];

if($_POST['SubmitDraf'])
	include("simpan_soalan.php");
elseif($_POST['SubmitSoalan'])
	include("simpan_hantar_soalan.php");
elseif($_POST['EditSoalan'] || $_POST['Refresh']){
	include("query_soalan.php");
	include("edit_soalan.php");	
}
elseif($_POST['EditSoalan'] || $_POST['Refresh']){
	include("query_soalan.php");
	include("edit_soalan.php");	
}
elseif($_POST['EditJawapan']){
	$jawapan_id = $_POST['jawapan_id'];
	$status = $_POST['status_id'];
	include("edit_jawapan.php");
	
}elseif($_POST['SimpanDanHantarJawapan']){
	include("simpan_hantar_jawapan.php");	
}elseif($_POST['SimpanJawapan']){
	include("simpan_jawapan.php");	
}
elseif($_POST['EditFinal']){
	include("edit_final.php");	
}elseif($_POST['SimpanJawapanAkhir']){
	include("simpan_jawapanakhir.php");	
}elseif($_POST['SimpanHantarJawapanAkhir']){
	include("simpan_hantar_jawapanakhir.php");
}
elseif($_POST['EditKorperat'])
	include("edit_korperat.php");
elseif($_POST['SimpanKorperat'])
	include("simpan_korperat.php");	
elseif($_POST['SimpanDanHantarKorperat'])
	include("simpan_hantar_korperat.php");
	
elseif($_POST['EditPengurusan'])
	include("edit_pengurusan.php");
elseif($_POST['SimpanPengurusan'])
	include('simpan_pengurusan.php');		
elseif($_POST['SimpanDanHantarPengurusan'])
	include('simpan_hantar_pengurusan.php');
	
elseif($_POST['EditPengesahan'])
	include('edit_pengesahan.php');
elseif($_POST['SimpanPengesahan'])
	include('simpan_pengesahan.php');	
elseif($_POST['SimpanDanHantarPengesahan'])
	include('simpan_hantar_pengesahan.php');
	
elseif($_POST['SubmitRekodLama'])
	include('upload.php');
	
elseif($action == 'newdoc'){
	include("query_soalan.php");
	include("edit_soalan.php");		
}
elseif($action == 'olddoc'){
	include("query_soalan.php");
	include("rekod_lama.php");		
}

elseif($action == 'list'){
	include("view.php");
}elseif($action == 'details'){
	include("detail.php");
}

elseif($action == 'search'){
	include("search.php");	
}elseif($action == 'search'){
	include("result_carian.php");		
}	


?>