<?php
require('html2fpdf.php'); 

require('../config.php');
require('../keyword.php');
$id	= $_POST['id'];



$pdf=new HTML2FPDF();
$pdf->AddPage();

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

//$pdf=new PDF_MC_Table('P','cm','A4');
//$pdf=new PDF_HTML('P','cm','A4');
/*$pdf->Open();
$pdf->AddPage();

$pdf->SetFont('Arial','B',12);
*/
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
 
$qry_sah = "SELECT * FROM semakan WHERE parlimen_id ='$id' AND status='9'";
	mysql_select_db($db_voffice,$conn) or die(mysql_error());
     $result_sah 	= mysql_query($qry_sah,$conn) or die(mysql_error());

	$rows_sah 				= mysql_fetch_array($result_sah);
	$totalRows = mysql_num_rows($result_sah );
	
if($totalRows>0)
{
	$jawatan_sah 		= $rows_sah['jawatan']; 
	if(($jawatan_sah=='PA TKSP (D)')||($jawatan_sah=='TKSP (D)'))
	{
	$lulus='TKSP (D)';
	}
	else if(($jawatan_sah=='PA TKSP (P)')||($jawatan_sah=='TKSP (P)'))
	{
	$lulus='TKSP (P)';
	}
	else if(($jawatan_sah=='PA TKSP (S&K)')||($jawatan_sah=='TKSP (S&K)'))
	{
	$lulus='TKSP (S&K)';
	}
	else if(($jawatan_sah=='PA KSP')||($jawatan_sah=='SUSK KSP')||($jawatan_sah=='PK KSP')||($jawatan_sah=='KSP'))
	{
	$lulus='KSP';
	}
	else{
	$qry_sah1 = "SELECT penyemak FROM parlimen WHERE id ='$id'";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result_sah1 	= mysql_query($qry_sah1,$conn) or die(mysql_error());

	$rows_sah1 				= mysql_fetch_array($result_sah1);
	$lulus=$rows_sah1['penyemak'];
	}
}
else{
$qry_sah1 = "SELECT penyemak FROM parlimen WHERE id ='$id'";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result_sah1 	= mysql_query($qry_sah1,$conn) or die(mysql_error());

	$rows_sah1 				= mysql_fetch_array($result_sah1);
	$lulus=$rows_sah1['penyemak'];
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
{$stat="(DRAF)";}
	else{ $stat="(JAWAPAN AKHIR)";}
	
	
 if ($nama_kawasan =='') { 

    $YB=$gelarYB.' '.stripslashes($nama);
   }else {  
   $YB2=$gelarYB.' '.stripslashes($nama);
  $YB=$gelarYB.' '.stripslashes($nama).'('.$nama_kawasan.')';
    
   } 

/*
$qry = "SELECT * FROM sesi_bahas_detail WHERE bahas_id='6'";
//$qry = "SELECT * FROM parlimen WHERE id='$id'";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result = mysql_query($qry,$conn) or die(mysql_error());
while($row2 = mysql_fetch_array($result))
{
	//$cid = $row2['ref_no']; 'korperat_jawapan'
	$jawapan = $row2['jawapan'];
	//$jawapan = $row2['korperat_jawapan'];
}*/
//$fp = fopen("sample.html","r");
//$strContent = fread($fp, filesize("sample.html"));
//fclose($fp);
$pdf->SetMargins(15.0,15.0,15.0,15.0);  
  
//$pdf->SetLeftMargin(15.0);
//$pdf->SetRightMargin(15.0);
$pdf->SetTextColor(0,0,0);
$pdf->Ln(10.0);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,"NO SOALAN : $no_soalan",0,1,'R');
$pdf->Ln(10.5);
//$pdf->Ln(3);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,0,"PEMBERITAHUAN PERTANYAAN ",0,1,'C');
$pdf->Ln(5.5);

$pdf->Cell(0,0," $dewan , MALAYSIA ",0,1,'C');
$pdf->SetFont('');
$pdf->Ln(8.5);
//$pdf->Ln(1.0);
//$pdf->Cell(0,0,"PERTANYAAN  : ".strtoupper($rows['bentuk_soalan']),0,1,'L');
$pdf->Ln(8.5);
//$pdf->SetFont('Arial','B',11);
$margin=15.5;
$marginb='';
$marginc=30.5;
//$pdf->SetMargins($margin);
//$namaPar=""."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[$nama_kawasan]";
if($nama_kawasan!="")
{
$namamp="<strong><table width=100% border=0 >
<tr>
   <td width=24%>DARIPADA</td>
    <td width=2%>:</td>
    <td>".$YB2."</td>
  </tr>
</table></strong>";
}
else
{
$namamp="<strong><table width=100% border=0 >
<tr>
   <td width=24%>DARIPADA</td>
    <td width=2%>:</td>
    <td>".$YB."</td>
  </tr>
</table></strong>";
}
$pdf->SetFont('Arial','B',12);
$pdf->WriteHTML($namamp);
if($nama_kawasan!="")
{
$kawasan="<strong><table width=100% border=0>
<tr>
   <td width=24%>&nbsp;</td>
    <td width=2%>&nbsp;</td>
    <td>[".$nama_kawasan."]</td>
  </tr>
</table></strong>";
$pdf->WriteHTML($kawasan);
$pdf->Ln(1.5);
}


//$pdf->SetFont('Arial','B',11);

$tanyaan="<strong><table width=100% border=0>
<tr>
   <td width=24%>PERTANYAAN </td>
    <td width=2%>:</td>
    <td>".strtoupper($rows['bentuk_soalan'])."</td>
  </tr>
</table></strong>";
$pdf->WriteHTML($tanyaan);
$pdf->Ln(1.5);

$tarikh="<strong><table width=100% border=0>
<tr>
   <td width=24%>TARIKH</td>
    <td width=2%>:</td>
    <td>".date("d/m/Y",strtotime($rows['tkh_bentang_jawapan']))."</td>
  </tr>
</table></strong>";
$pdf->WriteHTML($tarikh);
$pdf->Ln(1.5);

$pdf->Ln(9.5);
//$pdf->Ln(0.5);
$soalan_="<strong><table width=100% border=0>
<tr>
   <td width=24%>SOALAN</td>
    <td width=2%>:</td>
    <td>&nbsp;</td>
  </tr>
</table></strong>";
$pdf->WriteHTML($soalan_);
$pdf->Ln(7.5);
$pdf->SetFont('');
$soalan="<p align='justify'>".$soalan."</p>";
$pdf->WriteHTML($soalan);
$pdf->Ln(9.5);
//$pdf->Ln(1.0);

$jawapan_="<strong><table width=100% border=0>
<tr>
   <td width=24%>JAWAPAN</td>
    <td width=2%>:</td>
    <td>&nbsp;</td>
  </tr>
</table></strong>";
$pdf->Ln(9.5);
$pdf->WriteHTML($jawapan_);
$pdf->Ln(8.5);

$jawapan="<p align='justify'>".$jawapan."</p>";
$pdf->WriteHTML($jawapan );
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,"MAKLUMAT TAMBAHAN : ",0,1,'L');
$pdf->Ln(8.5);
$pdf->SetFont('');
$pdf->WriteHTML($makTamb);
$pdf->AddPage();

$pdf->Ln(0.5);
$SomeSpecialChars = array("’");
$ReplacementChars = array("'");
$Disemak_String = str_replace($SomeSpecialChars, $ReplacementChars, $rows2['disemak_oleh']);
$disediakan_String = str_replace($SomeSpecialChars, $ReplacementChars, $rows2['penyedia_nama']);
$dihantar_kepada_String = str_replace($SomeSpecialChars, $ReplacementChars, $rows2['pengesah_nama']);

$disediakan="<strong><table width=100% border=0>
  <tr>
    <td width=30%>DISEDIAKAN OLEH</td>
    <td width=2%>:</td>
    <td>".strtoupper($disediakan_String)."</td>
  </tr>
  <tr>
    <td>JAWATAN</td>
    <td>:</td>
    <td>".strtoupper($rows2['penyedia_jawatan'])."</td>
  </tr>
  <tr>
    <td>NO. TELEFON</td>
    <td>:</td>
    <td>".$rows2['penyedia_no_tel_pej']."</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
</table></strong>";



$disemak="<strong><table width=100% border=0>
<tr>
    <td width=30%>DISEMAK OLEH</td>
    <td width=2%>:</td>
    <td>".strtoupper($Disemak_String)."</td>
  </tr>
  <tr>
    <td>JAWATAN</td>
    <td>:</td>
    <td>".strtoupper($rows2['penyemak_jawatan'])."</td>
  </tr>
  <tr>
    <td>NO. TELEFON</td>
    <td>:</td>
    <td>".$rows2['penyemak_no_tel_pej']."</td>
  </tr>
  <tr>
    <td>NO. H/P</td>
    <td>:</td>
    <td>".$rows2['penyemak_no_hp']."</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table></strong>";

$dihantar_kepada="<strong><table width=100% border=0>
<tr>
    <td width=30%>DIHANTAR KEPADA</td>
    <td width=2%>:</td>
    <td>".strtoupper($dihantar_kepada_String)."</td>
  </tr>
  <tr>
    <td>JAWATAN</td>
    <td>:</td>
    <td>".strtoupper($rows2['pengesah_jawatan'])."</td>
  </tr>
  <tr>
    <td>NO. TELEFON</td>
    <td>:</td>
    <td>".$rows2['pengesah_no_tel_pej']."</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 </table></strong>";

$disahkan="<strong><table width=100% border=0>
<tr>
   <td width=30%>DISAHKAN OLEH</td>
    <td width=2%>:</td>
    <td>".strtoupper(stripslashes($rows4['nama']))."</td>
  </tr>
  <tr>
    <td>JAWATAN</td>
    <td>:</td>
    <td>".strtoupper($rows4['jawatan'])."</td>
  </tr>
  <tr>
    <td>NO. TELEFON</td>
    <td>:</td>
    <td>".$rows4['telefon']."</td>
  </tr>

</table></strong>";
$pdf->WriteHTML($disediakan);
$pdf->Ln(1.5);
$pdf->WriteHTML($disemak);
$pdf->Ln(1.5);
//$dihantar_kepada=stripslashes($dihantar_kepada);
$pdf->WriteHTML($dihantar_kepada);
if($status==9)
{	
$pdf->Ln(1.5);
$pdf->WriteHTML($disahkan);
}







$pdf->Output();
echo "PDF file is generated successfully!\n"; 
//echo $dihantar_kepada;
//print_r $dihantar_kepada;

/*
$qry = "SELECT * FROM sesi_bahas_detail WHERE bahas_id='6'";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result = mysql_query($qry,$conn) or die(mysql_error());
while($row2 = mysql_fetch_array($result))
{
	$cid = $row2['ref_no'];
	$jawapan = $row2['jawapan']; 
}
echo $jawapan; 
*/
?>