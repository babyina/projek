<?php
#part of index.php

$action = $_GET['action'];
$mode = $_GET['mode'];

if($_POST['SubmitDraf'])
{
	include("simpan_soalan.php"); 
	exit;
}	
elseif($_POST['SubmitSoalan'])
{
	include("simpan_hantar_soalan.php"); 
	exit;
	}
elseif($_POST['test']){
	include("query_soalan.php"); 
	include("test.php");	
	}
elseif($_POST['EditSoalan'] || $_POST['Refresh']){
	include("query_soalan.php");
	include("edit_soalan.php");	
	exit;
}
elseif($_POST['EditSoalan'] || $_POST['Refresh']){
	include("query_soalan.php");
	include("edit_soalan.php");	
	exit;
	
}
elseif($_POST['EditSoalan2'] || $_POST['Refresh']){
	include("query_soalan.php");
	include("edit_hantar_semula.php");	
	exit;
	
}
//detail_bcp 23052011
elseif($_POST['detail_bcp'] || $_POST['Refresh']){
	include("detail_bcp.php");
	
	exit;
	
}
elseif($_POST['SimpanSoalan']){
		
	include("SimpanSoalan.php");	
	exit;
}

elseif($_POST['EditJawapan']){
	$jawapan_id = $_POST['jawapan_id'];
	$status = $_POST['status_id'];
	include("edit_jawapan.php");
	exit;

}elseif($_POST['SimpanDanHantarJawapan']){
	include("simpan_hantar_jawapan.php");	
	exit;
}elseif($_POST['SimpanJawapan']){
		$status = $_POST['status'];	
	include("simpan_jawapan.php");	
	exit;
}
elseif($_POST['EditFinal']){
	include("edit_final.php");	
	exit;
}elseif($_POST['SimpanJawapanAkhir']){
	include("simpan_jawapanakhir.php");	
//jawapan akhir bcp
}elseif($_POST['SimpanJawapanAkhirBcp']){
	include("simpan_jawapanakhir_bcp.php");	
}elseif($_POST['SimpanHantarJawapanAkhir']){
	include("simpan_hantar_jawapanakhir.php");
	exit;
}
elseif($_POST['EditKorperat'])
	include("edit_korperat.php");
elseif($_POST['SimpanKorperat'])
	include("simpan_korperat.php");	
elseif($_POST['SimpanDanHantarKorperat'])
	include("simpan_hantar_korperat.php");
	
elseif($_POST['EditPengurusan']){
	include("edit_pengurusan.php");
	exit;
	}
elseif($_POST['EditPengurusan4'])
	include("edit_pengurusan4.php");
	
elseif($_POST['SimpanPengurusan'])
	include('simpan_pengurusan.php');		
elseif($_POST['SimpanDanHantarPengurusan'])
{
	include('simpan_hantar_pengurusan.php');
	exit;
	}
elseif($_POST['SimpanDanHantarPengurusanKoperat'])
	include('simpan_hantar_pengurusan_koperat.php');
	
elseif($_POST['EditPengesahan'])
{
	include('edit_pengesahan.php');
	exit;
}	
elseif($_POST['SimpanPengesahan'])
	include('simpan_pengesahan.php');	
elseif($_POST['SimpanDanHantarPengesahan'])
{
	include('simpan_hantar_pengesahan.php');
	exit;
}	
elseif($_POST['SimpanDandrafakhir'])
{
	include('simpan_hantar_draf_akhir.php');
exit;	
}
elseif($_POST['SubmitRekodLama']){
	include('simpan_rekod_lama.php');
	exit;
	}
	
elseif($_POST['hapuslampiran']){
	include('hapus_dokumen_lampiran.php');
	include('edit_jawapan.php');
	exit;
}
	
elseif($_POST['Edit_RekodLama']){
	$Hapus = $_POST['Edit_RekodLama'];
	$l_id = $_POST['lampiran_id'];
	include("query_soalan.php");
	include("rekod_lama.php");
	exit;
	}
elseif($_POST['HapusRekod'])
	include('hapus.php');


	
//---------------sesi bahas ----------------	

elseif($_POST['SimpanBahas'])
	include('bahas.php');
elseif($_POST['EditBahas'])
	include('bahas.php');			
elseif($_POST['UpdateBahas'])
	include('bahas.php');
elseif($_POST['deleteDoc'])
	include('bahas.php');
elseif($_POST['deletePP'])
	include('bahas.php');
	
elseif($_POST['TambahPerkaraBerbangkit'])
	include('perkara_berbangkit.php');
elseif($_POST['SimpanPerkaraBerbangkit'])
	include('perkara_berbangkit.php');			
elseif($_POST['SimpanHantarPerkaraBerbangkit'])
	include('perkara_berbangkit.php');	
elseif($_POST['EditPerkaraBerbangkit'])
	include('perkara_berbangkit.php');			
elseif($_POST['UpdatePerkaraBerbangkit'])
	include('perkara_berbangkit.php');
			
elseif($_POST['EditJawapanBahas']){
	$bahas_id = $_POST['id'];
	$jawapan_id = $_POST['jawapan_id'];
	$status = $_POST['status_id'];
	include("jawapan_bahas.php");	
}elseif($_POST['SimpanDanHantarJawapanBahas'])
	include("jawapan_bahas.php");	
elseif($_POST['SimpanJawapanBahas'])
	include("jawapan_bahas.php");
	
elseif($_POST['EditKorperatBahas'])
	include("bahas_korperat.php");	
elseif($_POST['SimpanKorperatBahas']){
	$action = "false";
	include("bahas_korperat.php");	
}
elseif($_POST['SimpanDanHantarKorperatBahas']){
	$action = "false";
	include("bahas_korperat.php");	
}
	
elseif($_POST['EditPengurusanBahas'])
	include("bahas_pengurusan.php");
elseif($_POST['SimpanPengurusanBahas'])
	include("bahas_pengurusan.php");		
elseif($_POST['SimpanHantarPengurusanBahas'])
	include("bahas_pengurusan.php");

elseif($_POST['EditPengesahanBahas'])
	include("bahas_pengesahan.php");
elseif($_POST['SimpanPengesahanBahas'])
	include("bahas_pengesahan.php");		
elseif($_POST['SimpanHantarPengesahanBahas'])
	include("bahas_pengesahan.php");
	
elseif($_POST['EditFinalBahas']){
	include("bahas_final.php");	
}elseif($_POST['SimpanJawapanAkhirBahas']){
	include("bahas_final.php");	
}elseif($_POST['SimpanHantarJawapanAkhirBahas']){
	include("bahas_final.php");
}

if($_POST['hantar_kembali'])
{
 include("postback.php") ;
}
//----------- action ---------------------
					
elseif($action == 'newdoc'){
	include("query_soalan.php");
	include("edit_soalan.php");		
}
elseif($action == 'olddoc'){
	include("query_soalan.php");
	include("rekod_lama.php");		
}
elseif($action == 'list' || $action == ''){
	include("view.php");
}
elseif($action == 'details'){
	include("detail.php");
}
elseif($action == 'listbahas'){
	include("bahas.php");
}
elseif($action == 'listview'){
	include("view_bahas.php");	
}
elseif($action == 'detailsbahas'){
	include("detail_bahas.php");
}
elseif($action == 'jawapan'){
	include("form_jawapan.php");
}
elseif($action == 'search' and $_GET['rekod'] == 0 and $_GET['title']!="C2"){
	include("search.php");	
}
elseif($action == 'search' and $_GET['rekod'] == 0 and $_GET['title']=="C2"){
	include("search_tahun.php");	
}
elseif($action == 'search' and $_GET['rekod'] == 1){
	include("../../soal_jawab/index2.php");	
	//include("../../soal_jawab/search.js");	
	//include("../../soal_jawab/java_search.php");	
	
}
elseif($action == 'CarianLengkap'){
	include("form_carian.php");
}
elseif($action == 'KeputusanCarian'){
	include("result_carian.php");	
}
elseif($action == 'rekodlama'){
	include("view_rekodlama.php");		
}	
elseif($action == 'RekodBaru'){
	include("bahas.php");		
}
elseif($action == 'listRizal'){
	include("viewRizal.php");
}


//---------------laporan status jawapan pertanyaan----------------	
//if($_POST['Papar'])
	//include("lap_status.php");

elseif($action == 'laporanStatus'){
	include("lap_aturan_select.php");
}
elseif($action == 'laporanbyrequest'){
	include("lap_byrequest.php");
}
elseif($action == 'laporanStatusBahas'){
	include("lap_aturan_bahas.php");
}



?>