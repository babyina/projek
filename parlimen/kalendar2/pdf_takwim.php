<?php
require('class_pdf.php');
include('../config.php');
include('../keyword.php');
//require('include/func.php');

function Hari($date){
	if($date == "0000-00-00")
		return $date = "";
	else{
		$exp = explode("-",$date);
		$get_date = date("w", mktime(0,0,0,$exp[1],$exp[2],$exp[0]));
		$hari_array = array("Ahad","Isnin","Selasa","Rabu","Khamis","Jumaat","Sabtu");
		$date = $hari_array[$get_date];
		return $date;
	}
}

function Week($date){
 	//$date = explode("-",$date);
	//$week = date("W",mktime(0,0,0,$date[1],$date[2],$date[0]));
	$unixDate = strtotime($date);
	$week = date("W", $unixDate);
	return $week;
}

$mesyuarat_id = $_GET['mesyuarat_id'];
$sesi = $_GET['sesi'];

$dewan = ($sesi == 1)?"DEWAN RAKYAT":"DEWAN NEGARA";

$pdf = new PDF_TAKWIM('L','cm','A4');
$pdf->AddPage();
$pdf->Image('../images/logo1.jpg',13.5,0.5,3);
$pdf->SetFont('Arial','B',12);
$pdf->SetY(3);
$pdf->Cell(27.5,1,'RINGKASAN LAPORAN PEGAWAI BERTUGAS PARLIMEN (SEHINGGA 11 MEI 2006)',0,1,'C');
$pdf->SetY(4);
$pdf->Cell(27.5,1,$dewan,0,1,'C');

$query = "SELECT Tarikh, PegawaiBtugas, Sesi, Catatan FROM kal_pegawaitugas WHERE Kal_mesyuarat_id = '$mesyuarat_id' ORDER BY Tarikh";
$sql = mysql_query($query);

($pdf->PageNo() == 1)? $pdf->SetY(6.5):$pdf->SetY(3);

$check_hari = "";
$check_date = "";
$check_week = 0;
$weekCounter = 0;

while($row = mysql_fetch_array($sql)){
	$tarikh = $row[0];
	$pegawai = $row[1];
	$sesi = $row[2];
	$catatan = $row[3];
	
	$current_hari = $tarikh;
	$current_date = $tarikh;
	$current_week = Week($tarikh);
	
	
	($current_hari != $check_hari)? $print_hari = Hari($tarikh):$print_hari = "";
	($current_date != $check_date)? $print_date = Reverse($tarikh):$print_date = "";
	
	if($sesi == "CUTI"){ $sesi = ""; }
	$duplicateWeek = ($current_week == $check_week)? true:false;
	
	if(!$duplicateWeek){
	 	$weekCounter++;
	 	$pdf->SetTextColor(51,0,102);
	 	$pdf->SetFont('Arial','B',12);
		$pdf->Cell(27.5,1,'MINGGU ' . $weekCounter, 1,1);
	}
	
	$pdf->SetWidths(array(2,4,7,2,12.5));
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Row(array($print_hari,$print_date,$pegawai,$sesi,$catatan));
	
	$check_hari = $current_hari;
	$check_date = $current_date;
	$check_week = $current_week;
}

$pdf->Output();
?>