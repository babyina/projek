<?php
session_cache_limiter('public');
session_start();
if (!isset($_SESSION['valid'])) {
	echo "Unauthorized User!";
	exit(0);
}

include("bahas_table.php");
include("../config.php");
include("../keyword.php");

$pdf=new PDF_MC_Table('L','cm','A4');
$pdf->Open();
$pdf->AddPage();	

$sesi = $_POST['Sesi'];
$tarikh= formatDate(MysqlDate($_POST['TkhMulaBersidang']));
$mesyuarat = $_POST['Mesyuarat'];
$penggal= $_POST['Penggal'];
$parlimen= $_POST['Parlimen'];
$date = MysqlDate($_POST['TkhMulaBersidang']);

	
//-------------------  sesi_bahas -------------------------

mysql_select_db($db_voffice,$conn) or die(mysql_error());
$qry = "SELECT sesi_bahas.id,sesi_bahas.tajuk,sesi_bahas.sesi,sesi_bahas.parlimen AS parlimen,sesi_bahas.penggal AS penggal,sesi_bahas.mesyuarat AS mesyuarat,
		sesi_bahas.tkh_mula,sesi_bahas.tkh_akhir,sesi_bahas.status_bahas FROM sesi_bahas
		WHERE sesi_bahas.sesi = '$sesi' AND sesi_bahas.tkh_mula < '$date' AND
		mesyuarat = '$mesyuarat' AND penggal = '$penggal' AND parlimen = '$parlimen'
		Order By sesi_bahas.tkh_mula ASC";
//echo $qry;

$result1 = mysql_query($qry,$conn) or die(mysql_error());
$total1 = mysql_num_rows($result1);
if($total1==0){
	echo "Tiada rekod!";
	exit(0);
}

$bil = 0;
while($row = mysql_fetch_array($result1)){
	
	$bil++;
	$id = $row['id'];
	$tajuk = $row['tajuk'];
	$tkh_mula = $row['tkh_mula'];
	$tkh_akhir = $row['tkh_akhir'];
	$tkh_gulung = $row['tkh_gulung'];
	$status = $row['status_bahas'];
	if(empty($status))
		$status = "Jawapan Sedang Disediakan";
		
	$pdf->SetTextColor(0,0,0);
	$pdf->Ln(1.5);
	
	
	//-------------------  sesi_bahas_detail -------------------------
	
	//$qry2 = "SELECT * FROM sesi_bahas_detail WHERE sesi_bahas_detail.bahas_id='$id' AND tkh_dibahas BETWEEN '$tkh_mula' and '$tkh_akhir'
			//Order By sesi_bahas_detail.tkh_dibahas ASC";
			
	$qry2 = "SELECT * FROM sesi_bahas_detail WHERE sesi_bahas_detail.bahas_id='$id'
			Order By sesi_bahas_detail.tkh_dibahas ASC";
	$result2 = mysql_query($qry2,$conn) or die(mysql_error());
	
	//echo $qry2;
	while($rows = mysql_fetch_array($result2)){
	
		$cid = $rows['ref_no'];
		$perkara = $rows['perkara'];
		$penanya = $rows['yb'];
		$tarikh = formatDate($rows['tkh_dibahas']);	
	
		if($tarikh<>$tkh)
		{
			$pdf->Ln(1);
			$pdf->SetFont('Arial','B',12);	
			$pdf->Cell(0,0,"PERKARA YANG DIBANGKITKAN SEMASA ".strtoupper($tajuk)." PADA "."$tarikh",0,1,'C');
			$pdf->Ln(1);
			$pdf->SetTextColor(0,0,0);
			//$pdf->SetFillColor(83,169,255);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(8,0.6,"DIBANGKITKAN OLEH",1,0,'C',1);
			$pdf->Cell(14,0.6,"PERKARA YANG DIBANGKITKAN",1,0,'C',1);
			$pdf->Cell(6,0.6,"STATUS",1,0,'C',1);
			
			$pdf->Ln(0.6);
			$pdf->SetFillColor(255,255,255);
		}
			//$tindakan = getAgensiName($rows['agensi'],$conn);	
		$pdf->SetFont('Arial','',12);
		$pdf->SetWidths(array(8,14,6));
		$pdf->Row(array($penanya,$perkara,$status));
		$i++;
		$tkh = $tarikh;
	}
}	


mysql_close();
$pdf->Output();
?>
