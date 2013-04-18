
<?php
//require('html2fpdf.php'); 

require('../config.php');
require('../keyword.php');
$id	= $_POST['id'];
ini_set("memory_limit","256M");


//$pdf=new HTML2FPDF();
//$pdf->AddPage();

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
$no_soalan_data 			= $rows['no_soalan'];
$bentuk=$rows['bentuk_soalan'];
$korperat_nama 		= addslashes($rows['korperat_nama']);
$korperat_jawatan 	= $rows['korperat_jawatan'];
//$korperat_jawapan 	= strip_tags($rows['korperat_jawapan']);
$korperat_jawapan 	=$rows['korperat_jawapan'];
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

 

   $YB=$gelarYB.' '.stripslashes($nama);
 

if(strtoupper(($rows['sesi_dewan']==1)))
{
$dewan="DEWAN RAKYAT";
}
else{
$dewan="DEWAN NEGARA";
}


//$pdf->Cell(0,0,"PEMBERITAHUAN PERTANYAAN ",0,1,'C');
//$pdf->Output();

   // require('../parlimen/parlimen/tcpdf/html2pdf.class.php');
	  
	 $no_soalan="<div align='right'><strong>NO SOALAN :".$no_soalan_data."</strong></div>";
    
	 
	  
	
 
 

	$pertanyaan_dewan="<div align='center '><strong>PEMBERITAHUAN PERTANYAAN </strong></div>";
	
	
  
  
  	$dewan= "<div align='center'><strong>".$dewan.", MALAYSIA </strong></div>";
	



$namamp= "<div align='left'><strong>DARIPADA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:".$YB."</strong></div>";

if($nama_kawasan!="")
{
$kawasan="<div align='left'><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[".$nama_kawasan."]</strong></div>";
$kawasan2="<strong><table width=100% border=0>
<tr>
   <td width=24%>&nbsp;</td>
    <td width=2%>:</td>
    <td>[".$nama_kawasan."]</td>
  </tr>
</table></strong>";

}
$tanyaan="<div align='left'><strong>PERTANYAAN  &nbsp;&nbsp;:".strtoupper($rows['bentuk_soalan'])."</strong></div>";
$tanyaan2="<strong><table width=100% border=0>
<tr>
   <td width=24%>PERTANYAAN </td>
    <td width=2%>:</td>
    <td>".strtoupper($rows['bentuk_soalan'])."</td>
  </tr>
</table></strong>";

$tarikh="<div align='left'><strong>TARIKH &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:".date("d/m/Y",strtotime($rows['tkh_bentang_jawapan']))."</strong></div>";
$tarikh2="<strong><table width=100% border=0>
<tr>
   <td width=127>TARIKH</td>
    <td width=25>:</td>
    <td>".date("d/m/Y",strtotime($rows['tkh_bentang_jawapan']))."</td>
  </tr>
</table></strong>";


   
$soalan_= "<div align='left'><strong>SOALAN </strong></div>";  

$soalan_5="<strong><table width=100% border=0>
<tr>
   <td width=127>SOALAN</td>
    <td width=25>:</td>
    <td>&nbsp;</td>
  </tr>
</table></strong>";

   ob_start();
//$soalan=$soalan;
//$soalan = ob_get_clean();
$soalan="<p align='justify'>".$soalan."</p>";
$jawapan_= "<div align='left'><strong>JAWAPAN </strong></div>"; 
$label_tambahan= "<div align='left'><strong>MAKLUMAT TAMBAHAN </strong></div>";   

$jawapan_6="<strong><table width=100% border=0>
<tr>
   <td width=24%>JAWAPAN</td>
    <td width=2%>:</td>
    <td>&nbsp;</td>
  </tr>
</table></strong>";

include("../mpdf/mpdf.php");  
//include("../mpdf.php");

$mpdf=new mPDF(); 

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list
//$mpdf->Cell(0,0,"NO SOALAN : $no_soalan",0,1,'R');
// LOAD a stylesheet
$stylesheet = file_get_contents('../mpdf/examples/mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->writeHTML($no_soalan);
$mpdf->Ln(10.5);
$mpdf->writeHTML($pertanyaan_dewan);
$mpdf->Ln(5.5);
$mpdf->writeHTML($dewan); 
$mpdf->Ln(8.5);  
$mpdf->writeHTML($namamp); 
$mpdf->writeHTML($kawasan);
$mpdf->Ln(1.5);
$mpdf->writeHTML($tanyaan);
if(($rows['bentuk_soalan']!='Bertulis')) 

{
$mpdf->Ln(1.5);
$mpdf->writeHTML($tarikh);
}
$mpdf->Ln(9.5);
$mpdf->writeHTML($soalan_);
 $mpdf->Ln(7.5);   
 $mpdf->SetFont('Arial','B',11);        
$mpdf->WriteHTML($soalan); 
$mpdf->Ln(9.5);
$mpdf->SetFont('Arial','B',11);      
$mpdf->WriteHTML($jawapan_); 
$mpdf->Ln(8.5);
$mpdf->WriteHTML($korperat_jawapan ); 
$mpdf->Addpage();

$mpdf->Ln(8.5);
$mpdf->SetFont('');
$mpdf->WriteHTML($label_tambahan);
$mpdf->Ln(8.5);
$mpdf->WriteHTML($makTamb);
$mpdf->Addpage();
$mpdf->Ln(0.5);

$SomeSpecialChars = array("’");
$ReplacementChars = array("'");
$Disemak_String = str_replace($SomeSpecialChars, $ReplacementChars, $rows2['disemak_oleh']);
$disediakan_String = str_replace($SomeSpecialChars, $ReplacementChars, $rows2['penyedia_nama']);
$dihantar_kepada_String = str_replace($SomeSpecialChars, $ReplacementChars, $rows2['pengesah_nama']);

//$disediakan="<div align='left'><strong>DISEDIAKAN OLEH :".strtoupper($disediakan_String)."</strong></div>";   

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
$mpdf->WriteHTML($disediakan,2);
//$mpdf->Ln(1.5);
$mpdf->WriteHTML($disemak);
//$mpdf->Ln(1.5);
$mpdf->WriteHTML($dihantar_kepada); 
//$mpdf->Ln(1.5);
$mpdf->WriteHTML($disahkan);


$mpdf->Output();
exit;
/*	 
$mpdf=new mPDF('c'); 
$mpdf->mirrorMargins = true;
// LOAD a stylesheet
$stylesheet = file_get_contents('../mpdf/examples/mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

//$mpdf->SetDisplayMode('fullpage');

//$mpdf->WriteHTML($html);
$mpdf->WriteHTML($soalan);
$mpdf->Output();
//exit;
echo "PDF file is generated successfully!"; 

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