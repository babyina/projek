<?php
session_cache_limiter('public');
session_start();
if (!isset($_SESSION['valid'])) { 
	echo "Unauthorized User!";
	exit(0);
}
	
function adate($temp){
	return $temp;
}
		
function DeptNPeg($string){
	$lines = explode(";",$string);
	foreach($lines as $line){		
		$str = explode("+",$line);
		$tindakan[] = $str[0]." - ".$str[1];
		unset($str);
	}
	return implode(",",$tindakan);
}

function getYB($conn,$yb){
	$qry = "SELECT nama FROM ahli_parlimen WHERE id='$yb'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$yb = $row['nama'];
	return $yb;
}

function getAgensi($conn,$agensi){
	//$qry = "SELECT nama_pendek FROM agensi WHERE id='$agensi'";
	$qry = "SELECT nama FROM agensi WHERE id='$agensi'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$agensi = $row['nama'];
	return $agensi;
}

include("mc_table.php");
include("../config.php");
include("../keyword.php");

$pdf=new PDF_MC_Table('L','cm','A4');

$pdf->Open();
$pdf->AddPage();

$pdf->SetFont('Arial','B',12);

$current_time = date("d/m/Y");
$dewan = $_POST['Sesi'];
//$tarikh_mula = $_POST['TkhMulaBersidang'];
$tarikh_mula = mysqlDate($_POST['TkhMulaBersidang']);

$qry = "SELECT parlimen.parlimen,parlimen.penggal,parlimen.mesyuarat AS mesyuarat FROM parlimen
		WHERE parlimen.tkh_mula_bersidang = '$tarikh_mula' AND parlimen.sesi_dewan = '$dewan'";

$result = mysql_query($qry,$conn) or die(mysql_error());
$rows = mysql_fetch_array($result);
$mesyuarat = $rows['mesyuarat'];
$penggal = $rows['penggal'];
$parlimen = $rows['parlimen'];
$sesi_dewan2 = (($dewan == 1)?"Dewan Rakyat":"Dewan Negara");

mysql_select_db($db_voffice,$conn) or die(mysql_error());

//kes lisan
$qry1 = "SELECT parlimen.perkara,parlimen.ahli_dewan_id,parlimen.sesi_dewan,parlimen.parlimen,parlimen.penggal,parlimen.mesyuarat AS mesyuarat,
		parlimen.no_soalan,parlimen.agensi,parlimen.tkh_bentang_jawapan,parlimen.status,
		agensi.nama_pendek AS nama_pendek,agensi.id AS agensi FROM parlimen
		INNER JOIN agensi ON parlimen.agensi = agensi.id
		WHERE parlimen.bentuk_soalan = 'Lisan' AND parlimen.tkh_mula_bersidang = '$tarikh_mula' AND parlimen.sesi_dewan = '$dewan'
		ORDER BY parlimen.tkh_bentang_jawapan ASC";
$result1 = mysql_query($qry1,$conn) or die(mysql_error()); 
$total1 = mysql_num_rows($result1);
//$row1 = mysql_fetch_array($result1);

//kes bukan lisan
$qry2 = "SELECT parlimen.perkara,parlimen.ahli_dewan_id,parlimen.sesi_dewan,parlimen.parlimen,parlimen.penggal,parlimen.mesyuarat AS mesyuarat,
		parlimen.no_soalan,parlimen.agensi,parlimen.tkh_bentang_jawapan,parlimen.status,
		agensi.nama_pendek AS nama_pendek,agensi.id AS agensi FROM parlimen
		Inner Join agensi ON parlimen.agensi = agensi.id
		WHERE parlimen.bentuk_soalan <> 'Lisan' AND parlimen.tkh_mula_bersidang = '$tarikh_mula' AND parlimen.sesi_dewan = '$dewan'
		Order By parlimen.tkh_bentang_jawapan ASC";
$result2 = mysql_query($qry2,$conn) or die(mysql_error());
$total2 = mysql_num_rows($result2);
//$row2 = mysql_fetch_array($result2);

$pdf->SetTextColor(0,0,0);
$pdf->Ln(0.5);
$pdf->Cell(0,0,"MESYUARAT ".strtoupper($mesyuarat).", "."PENGGAL ".strtoupper($penggal).", "."PARLIMEN ".strtoupper($parlimen),0,1,'C');
$pdf->Ln(0.5);
$pdf->Ln(1);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,0,"Status Jawapan Pertanyaan ".$sesi_dewan2." (Sehingga "."$current_time)",0,1,'C');
$pdf->Ln(0.5);
$pdf->Ln(0.5);

if($total1==0 && $total2==0){
	echo "Tiada rekod!";
	exit(0);
}

if($total1==0){
	if($total2>0)
		$coll = "PERTANYAAN BERTULIS";
      
}else
{
	$coll = "PERTANYAAN LISAN";		
     $pdf->label = "Lisan";
	 }
$_label = ($total1>0)?"Lisan":"Bertulis";

//$_label = ($total1>0)?"Lisan":"Bertulis";
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(1.5,0.6,"BIL",1,0,'C',1);
$pdf->Cell(8.5,0.6,"PERKARA",1,0,'C',1);
$pdf->Cell(4.5,0.6,"PENANYA",1,0,'C',1);
$pdf->Cell(5,0.6,"TARIKH & NOMBOR",1,0,'C',1);
$pdf->Cell(3.5,0.6,"BHG/AGENSI",1,0,'C',1);
$pdf->Cell(5,0.6,"STATUS",1,0,'C',1);
$pdf->Ln(0.5);
$pdf->SetFillColor(255,255,255);
//$pdf->Celtest(28,0.6,$coll,1,0,'L',1);
$pdf->Cell(28,0.6,$coll,1,0,'L',1);
$pdf->Ln();

$pdf->SetFont('Arial','',12);
$pdf->SetWidths(array(1.5,8.5,4.5,5,3.5,5));

$i=1;
while($row2 = mysql_fetch_array($result1)){
	$bil = $i;
	$perkara = $row2['perkara'];
	$penanya = getYB($conn,$row2['ahli_dewan_id']);
	$noSoalan = $row2['no_soalan'];
	$tarikh = DisplayDate($row2['tkh_bentang_jawapan']);
	$tindakan = getAgensi($conn,$row2['agensi']);
	$status = $doc_status[$row2['status']];
	$temp = ((empty($tarikh))?" ":", ");
	$pdf->Row(array($bil,$perkara,$penanya,$tarikh.$temp.$noSoalan,$tindakan,$status)); 
	$i++;
}
$pdf->label = "Bertulis";
if($total1>0 && $total2>0) $pdf->AddPage();
{
$pdf->label = "Bertulis";
$_label="Bertulis";
}
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);
//$pdf->Cell(1.5,0.6,"BIL",1,0,'C',1);
//$pdf->Cell(8.5,0.6,"PERKARA",1,0,'C',1);
//$pdf->Cell(4.5,0.6,"PENANYA",1,0,'C',1);
//$pdf->Cell(5,0.6,"TARIKH & NOMBOR",1,0,'C',1);
//$pdf->Cell(3.5,0.6,"BHG/AGENSI",1,0,'C',1);
//$pdf->Cell(5,0.6,"STATUS",1,0,'C',1);
//$pdf->Ln(0.5);
//$pdf->SetFillColor(255,255,255);
//$pdf->Celtest(28,0.6,$coll,1,0,'L',1);
//$pdf->Cell(28,0.6,$_label,1,0,'L',1);
//$pdf->Ln();
//$pdf->label = "Bertulis";
$j=1;
while($row1 = mysql_fetch_array($result2)){
	$bil = $j;
	$perkara = $row1['perkara'];
	$penanya = getYB($conn,$row1['ahli_dewan_id']);
	$noSoalan = $row1['no_soalan'];
	//$tarikh = DisplayDate($row1['tkh_bentang_jawapan']);
	$tarikh ='';
	$tindakan = getAgensi($conn,$row1['agensi']);
	$status = $doc_status[$row1['status']];
	$temp = ((empty($tarikh))?" ":", ");
	$pdf->Row(array($bil,$perkara,$penanya,$tarikh.$temp.$noSoalan,$tindakan,$status));
	$j++;
}
mysql_close();
$pdf->Output();
?>