<?php
//require('../fpdf/fpdf.php');
require('class_pdf.php');
require('../config.php');
include('../keyword.php');

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

$mesyuarat = $_GET['mesyuarat'];
$penggal = $_GET['penggal'];
$parlimen = $_GET['parlimen'];
$mesyuarat_id = $_GET['mesyuarat_id'];

$sesi = $_GET['sesi'];
//$dewan = ($sesi == 1)? "DEWAN RAKYAT":"DEWAN NEGARA";
$tahun = date('Y');

$first_text = "JADUAL BERTUGAS KEMENTERIAN KESIHATAN";
$second_text = "DI MESYUARAT ". strtoupper($mesyuarat) ." PENGGAL ". strtoupper($penggal) ." PARLIMEN ". strtoupper($parlimen) ." (TAHUN ". $tahun .")";

$pdf = new PDF_FILE('L','cm','A4');

$pdf->AddPage();
$pdf->Image('../images/logo1.jpg',13.5,0.5,3);
$pdf->SetFont('Arial','B',12);

$pdf->SetY(3);
$pdf->Cell(27.5,1,$first_text,0,0,'C');
$pdf->SetY(3.5);
$pdf->Cell(27.5,1,$second_text,0,0,'C');
$pdf->SetY(4.5);
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(27.5,1,$dewan,0,0,'C');
($pdf->PageNo() == 1)?$pdf->SetY(7.5):$pdf->SetY(3);
//$pdf->SetWidths(array(3,4,16,4.5));

$query = "select Tarikh, Sesi, PegawaiBtugas, Dewan from kal_pegawaitugas where Kal_mesyuarat_id ='$mesyuarat_id' order by Tarikh, Sesi";
$sql = mysql_query($query);
$check_hari = "";
$check_date = "";
$check_week = "";
$week_counter = 0;
$x = 0;



while($row = mysql_fetch_array($sql)){
	$tarikh = $row['Tarikh'];
	$sesi = $row['Sesi'];
	$pegawai = $row['PegawaiBtugas'];
	$currDewan	= $row['Dewan'];
 	$current_hari = $tarikh;
 	$current_week = Week($tarikh);
	  	
 	($current_hari != $check_hari)? $print_hari = Hari($tarikh):$print_hari = "";
 	($current_hari != $check_date)? $print_date = Reverse($tarikh):$print_date = "";
	$dplcateDewan = ($currDewan==$preDewan)? true:false;
	
	if (!$dplcateDewan){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(27.5,1,"DEWAN ".strtoupper($currDewan),1,1,'C');
	}
	
	if($sesi == "CUTI"){
		$query1 = "select * from kal_cuti where tarikh ='$tarikh'";
		$sql_1 = mysql_query($query1);
		$rows=mysql_fetch_array($sql_1);
		$cuti=$rows['cuti'];
		$pegawai="(CUTI :".$cuti.")";
	} 
 	//if($sesi == "CUTI"){ $pegawai = "CUTI"; }
 	$duplicateWeek = ($current_week == $check_week)? true:false;
	
 	if(!$duplicateWeek){
		$pdf->SetTextColor(51,0,102);
 	 	$week_counter++;
 	 	$pdf->SetFont('Arial','B',12);		
		$pdf->Cell(27.5,1,"MINGGU ".$week_counter,1,1,1);
	}

	

	$pdf->SetTextColor(0,0,0);
	$pdf->SetWidths(array(3,4,16,4.5));
 	$pdf->SetFont('Arial','',10);
 	
 	//$pdf->SetFillColor(255,255,255);
		
		$pdf->Row(array($print_hari,$print_date,$pegawai,''));
	

	
	$check_hari = $current_hari;
	$check_date = $current_hari;
	$check_week = $current_week;
	$preDewan	= $currDewan;
	$x++;
}

$pdf->Output();
?>