<?php
session_cache_limiter('public');
session_start();

if (!isset($_SESSION['valid'])) {
	echo "Unauthorized User!";
	exit(0);
}

include("mc_table.php");
include("writehtml_pdf.php");
include("../config.php");
include("../keyword.php");

function findHari($mysql_date){
   

	if($mysql_date == "0000-00-00") return "";
	
	//$mysql_date = 2005-05-05;
	$dt = explode("-",$mysql_date);
	
	$weekday = date("w",mktime(0,0,0,$dt[1],$dt[2],$dt[0]));	
	$weekname = array("Ahad","Isnin","Selasa","Rabu","Khamis","Jumaat","Sabtu");
	
	return $weekname[$weekday];
	
	
	/*$h = mktime(0, 0, 0, 10, 31, 2009);
$d = date("F dS, Y", $h) ;
$w= date("l", $h) ;
Echo "$d is on a $w";*/
	
}

$pdf=new PDF_MC_Table('P','cm','A4');
$pdf=new PDF_HTML('P','cm','A4');
$pdf->Open();
$pdf->AddPage();

$pdf->SetFont('Arial','B',12);

$current_time = date("d/m/Y");
$id 				= $_POST['id'];
$qry 				= "SELECT * FROM parlimen WHERE id='$id'";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result 			= mysql_query($qry,$conn) or die(mysql_error());

$rows 				= mysql_fetch_array($result);
$sesi_dewan 		= $rows['sesi_dewan'];
$ahli_dewan 		= $rows['ahli_dewan_id'];
$no_soalan 			= $rows['no_soalan'];
$bentuk=$rows['bentuk_soalan'];
$korperat_nama 		= addslashes($rows['korperat_nama']);
$korperat_jawatan 	= $rows['korperat_jawatan'];
$korperat_jawapan 	= strip_tags($rows['korperat_jawapan']);
$pengurusan_nama 	= addslashes($rows['pengurusan_nama']);
$pengurusan_jawatan	= $rows['pengurusan_jawatan'];
$pengesahan_nama	= addslashes($rows['pengesahan_nama']);
$pengesahan_jawatan = $rows['pengesahan_jawatan'];
$created_by 		= addslashes($rows['created_by']);
$created_on 		= $rows['created_on'];
$status		= $rows['status'];

$YBid	= $rows['ahli_dewan_id'];
$sqlYB	= "SELECT nama,pangkat,kawasan_id FROM ahli_parlimen WHERE id='$YBid'";
$rsYB	= mysql_query($sqlYB);
$rowYB	= mysql_fetch_array($rsYB);
$gelarYB= $rowYB['pangkat'];
$nama	= $rowYB['nama'];
$kawasan = $rowYB['kawasan_id'];
$hari = findHari($rows['tkh_bentang_jawapan']);

//$hari = findHari($rows['tkh_bentang_jawapan']);

$soalan 	= $rows['soalan'];
$jawapan	= $rows['korperat_jawapan'];
$makTamb	= $rows['korperat_tambahan'];

$query 	= "SELECT nama FROM kawasan WHERE id='$kawasan'";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result = mysql_query($query,$conn) or die(mysql_error());

$row_nama = mysql_fetch_array($result);
$nama_kawasan = $row_nama['nama'];


   $qry2 = "SELECT * FROM parlimen_agensi WHERE parlimen_id ='$id'";
	mysql_select_db($db_voffice,$conn) or die(mysql_error());
     $result2 	= mysql_query($qry2,$conn) or die(mysql_error());

	$rows2 				= mysql_fetch_array($result2);
	$penyemak2 		= $rows2['disemak_oleh'];
	$penyemakjaw    = $rows2['penyemak_jawatan'];
	$notel 		     = $rows2['penyemak_no_tel_pej'];

 if  ($jawapan =='')
  {
       $jawapan=$rows2['jawapan'];
       $makTamb	=$rows2['tambahan'];
 }
if(($korperat_jawatan=='PA TKSP (D)')||($korperat_jawatan=='TKSP (D)'))
{
$lulus='TKSP (D)';
}
else if(($korperat_jawatan=='PA TKSP (P)')||($korperat_jawatan=='TKSP (P)'))
{
$lulus='TKSP (P)';
}
else if(($korperat_jawatan=='PA TKSP (S&K)')||($korperat_jawatan=='TKSP (S&K)'))
{
$lulus='TKSP (S&K)';
}
else if(($korperat_jawatan=='PA KSP')||($korperat_jawatan=='SUSK KSP')||($korperat_jawatan=='PK KSP')||($korperat_jawatan=='KSP'))
{
$lulus='KSP';
}
 $qry4 = "SELECT * FROM pengguna WHERE jawatan ='$lulus'";
	mysql_select_db($db_voffice,$conn) or die(mysql_error());
     $result4 	= mysql_query($qry4,$conn) or die(mysql_error());

	$rows4 				= mysql_fetch_array($result4);
	


if(strtoupper(($rows['sesi_dewan']==1)))
{
$dewan="DEWAN RAKYAT";
}
else{
$dewan="DEWAN NEGARA";
}
if( $status!=9)
{$stat="DRAF";}
	else{ $stat="JAWAPAN AKHIR";}
	
	
 if ($nama_kawasan =='') { 
    $YB=$gelarYB.' '.stripslashes($nama);
   }else {  
  $YB=$gelarYB.' '.stripslashes($nama).'('.$nama_kawasan.')';
    
   } 
$pdf->SetTextColor(0,0,0);
$pdf->Ln(0.5);
$pdf->Cell(0,0,"NO SOALAN : $no_soalan",0,1,'R');
$pdf->Ln(0.5);
$pdf->Ln(1);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,0,"PEMBERITAHUAN PERTANYAAN ",0,1,'C');
$pdf->Ln(0.5);
$pdf->Cell(0,0," $dewan , MALAYSIA ($stat)",0,1,'C');
$pdf->Ln(0.5);
$pdf->Ln(1.0);
$pdf->Cell(0,0,"PERTANYAAN  : ".strtoupper($rows['bentuk_soalan']),0,1,'L');
$pdf->Ln(0.5);
$pdf->Cell(0,0,"DARIPADA        : ". $YB,0,1,'L');
$pdf->Ln(0.5);
$pdf->Cell(0,0,"TARIKH             : $hari, ".formatDate($rows['tkh_bentang_jawapan']),0,1,'L');
$pdf->Ln(0.5);
$pdf->Ln(0.5);
$pdf->Cell(0,0,"SOALAN           : ",0,1,'L');
$pdf->Ln(0.5);
$pdf->WriteHTML($soalan);
$pdf->Ln(0.5);
$pdf->Ln(1.0);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,0,"JAWAPAN          : ",0,1,'L');
$pdf->SetFont('');
$pdf->Ln(0.5);
$pdf->WriteHTML($jawapan);
$pdf->Ln(0.5);
$pdf->Ln(0.5);
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);
$pdf->Ln(0.5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,"MAKLUMAT TAMBAHAN : ",0,1,'L');
$pdf->SetFont('');
$pdf->Ln(0.5);
$pdf->WriteHTML($makTamb);
$pdf->Ln(0.5);
$pdf->Ln(0.5);
$pdf->Ln(1);
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Ln(0.5);
$pdf->Cell(0,0,"DISEDIAKAN OLEH : ".strtoupper($rows2['penyedia_nama']),0,1,'L');
$pdf->Ln(0.5);

$pdf->Cell(0,0,"JAWATAN : ".strtoupper($rows2['penyedia_jawatan']),0,1,'L');
$pdf->Ln(0.5);

$pdf->Cell(0,0,"NO. TELEFON : ".$rows2['penyedia_no_tel_pej'],0,1,'L');
$pdf->Ln(0.5);
$pdf->Ln(1.0);
$pdf->Cell(0,0,"DISEMAK OLEH : ".strtoupper($rows2['disemak_oleh']),0,1,'L');
$pdf->Ln(0.5);

$pdf->Cell(0,0,"JAWATAN : ".strtoupper($rows2['penyemak_jawatan']),0,1,'L');
$pdf->Ln(0.5);

$pdf->Cell(0,0,"NO. TELEFON : ".$rows2['penyemak_no_tel_pej'],0,1,'L');

$pdf->Ln(0.5); 
$pdf->Cell(0,0,"NO. H/P : ".$rows2['penyemak_no_hp'],0,1,'L');
$pdf->Ln(0.5);
$pdf->Ln(1.0);
$pdf->Cell(0,0,"DIHANTAR KEPADA : ".strtoupper(stripslashes($rows2['pengesah_nama'])),0,1,'L');
$pdf->Ln(0.5);

$pdf->Cell(0,0,"JAWATAN : ".strtoupper($rows2['pengesah_jawatan']),0,1,'L');

$pdf->Ln(0.5);
$pdf->Cell(0,0,"NO. TELEFON : ".$rows2['pengesah_no_tel_pej'],0,1,'L');
$pdf->Ln(0.5);
$pdf->Ln(1.0);
$pdf->Cell(0,0,"DISAHKAN OLEH : ".strtoupper(stripslashes($rows4['nama'])),0,1,'L');
$pdf->Ln(0.5);

$pdf->Cell(0,0,"JAWATAN : ".strtoupper($rows4['jawatan']),0,1,'L');

$pdf->Ln(0.5);
$pdf->Cell(0,0,"NO. TELEFON : ".$rows4['telefon'],0,1,'L');
$pdf->Ln(0.5);
$pdf->Ln(0.5);
mysql_close();
$pdf->Output();
?>