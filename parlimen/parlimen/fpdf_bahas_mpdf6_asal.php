<?php
//require('html2fpdf.php'); 

require('../config.php'); 
require('../keyword.php');
$id	= $_POST['id'];
ini_set("memory_limit","256M");


//$pdf=new HTML2FPDF();
//$pdf->AddPage();

$html_2 = '
<style>



.style1 {FONT-SIZE: 14pt;
         line-height: 1.5em;
		 font-family:  Sans-Serif;
		 text-align: justify; 
}
.style2 {FONT-SIZE: 14pt;
         line-height: 1.5em;
		 font-family: Sans-Serif;
		 font-weight:bold;
}

.style3{FONT-SIZE: 14pt;
         line-height: 12.5em;
		 font-family: Arial;
		
}

body,p,span,div,font,style {
 font-family: Sans-Serif;
 FONT-SIZE: 14pt;
 line-height: 1.5em; 
 text-align: justify;   }
</style>';

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
    $jawapan_agensi=$rows2['jawapan'];
 if  ($jawapan =='')
  {
       $jawapan=$rows2['jawapan'];
       $makTamb	=$rows2['tambahan'];
 }

 if ($rows['korperat_tambahan']=='')
 {
 $makTamb	=$rows2['tambahan'];
 }
 else{ $makTamb	= $rows['korperat_tambahan'];  }
 
 
 if($status!=9)
{
$korperat_jawapan=$jawapan_agensi;

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
	  
	 $no_soalan=$html_2."<body><div align='right'><strong>NO SOALAN :".$no_soalan_data."</strong></div></body>";
    
	 
	  
	
 
 

	$pertanyaan_dewan=$html_2."<body><div align='center '><strong>PEMBERITAHUAN PERTANYAAN </strong></div></body>";
	
	
  
  
  	$dewan= $html_2."<body><div align='center'><strong>".$dewan.", MALAYSIA </strong></div></body>";
	



$namamp_2= $html_2."<body><div align='left'><strong>DARIPADA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:".$YB."</strong></div></body>";
$namamp=$html_2."<table width=100% border=0 >
<tr>
   <td width=25%><div class='style2'>DARIPADA</div></td>
    <td width=2%><div class='style2'>:</div></td> 
	 <td ><div class='style2'>".$YB."</div></td>
   
  </tr>
</table>";

if($nama_kawasan!="")
{
$kawasan2=$html_2."<body><div align='left'><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(".$nama_kawasan.")</strong></div></body>";
$kawasan="<table width=100% border=0>
<tr>
   <td width=25%>&nbsp;</td>
    <td width=2%></td>
    <td><div class='style2'>(".$nama_kawasan.")</div></td>
  </tr>
</table>";

}
$tanyaan2=$html_2."<body><div align='left'><strong>PERTANYAAN  &nbsp;&nbsp;:".strtoupper($rows['bentuk_soalan'])."</strong></div></body>";
$tanyaan="<table width=100% border=0>
<tr>
   <td width=25%><div class='style2'>PERTANYAAN</div> </td>
    <td width=2%><div class='style2'>:</div></td>
    <td><div class='style2'>".strtoupper($rows['bentuk_soalan'])."</div></td>
  </tr>
</table>";

$tarikh2=$html_2."<div align='left'><strong>TARIKH &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:".date("d.m.Y",strtotime($rows['tkh_bentang_jawapan']))."</strong></div></body>";
$tarikh="<table width=100% border=0>
<tr>
   <td width=25%><div class='style2'>TARIKH</div></td>
    <td width=2%><div class='style2'>:</div> </td>
    <td><div class='style2'>".date("d.m.Y",strtotime($rows['tkh_bentang_jawapan']))."</div></td>
  </tr>
</table>";


   
$soalan_= $html_2."<body><div align='left'><strong>SOALAN </strong></div></body>";  

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
$soalan=$html_2."<body><div class='style1'><p align='justify'>".$soalan."</p></div></body>";
$korperat_jawapan =$html_2."<body><div class='style1'><p align='justify'>".$korperat_jawapan."</p></div></body>";
$makTamb =$html_2."<body><div class='style1'><p align='justify'>".$makTamb."</p></div></body>";
 if($status!=9)
{
$jawapan_= $html_2."<div align='left'><strong>DRAF JAWAPAN </strong></div></body>"; 
}
else
{
$jawapan_= $html_2."<div align='left'><strong>JAWAPAN </strong></div></body>"; 
}
$label_tambahan= $html_2."<body><div align='left'><strong>MAKLUMAT TAMBAHAN </strong></div></body>";   

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
$mpdf->Ln(1.0);
$mpdf->writeHTML($dewan); 
$mpdf->Ln(10.5);  
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
///$mpdf->SetFontSize(16);
//$mpdf->writeHTML($soalan_);
 //$mpdf->Ln(7.5);   
//$mpdf->SetFontSize(16,true) ;  
 //SetFont($family,$style='',$size=0, $write=true, $forcewrite=false) 
// $family='Arial';
 //$mpdf->SetFont($family,'',20, true,true) ;      
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

//$disediakan="<div align='left'><strong>DISEDIAKAN OLEH :".strtoupper($disediakan_String)."</strong></div>";   $html_2."<div class='style2'>

$disediakan= "<table width=100% border=0> 

  <tr>
    <td width=30%><div class='style2'>DISEDIAKAN OLEH</div></td>
    <td width=2%><div class='style2'>:</td>
    <td><div class='style2'>".$html_2.strtoupper($disediakan_String)."</div></td>
  </tr>
  <tr>
    <td><div class='style2'>JAWATAN</div></td>
    <td><div class='style2'>:</div></td>
    <td><div class='style2'>".strtoupper($rows2['penyedia_jawatan'])."</div></td>
  </tr>
  <tr>
    <td><div class='style2'>NO. TELEFON</div></td>
    <td><div class='style2'>:</div></td>
    <td><div class='style2'>".$rows2['penyedia_no_tel_pej']."</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
</table>";

 


$disemak="<strong><table width=100% border=0>
<tr>
    <td width=30%><div class='style2'>DISEMAK OLEH</div></td>
    <td width=2%><div class='style2'>:</div></td>
    <td><div class='style2'>".strtoupper($Disemak_String)."</div></td>
  </tr>
  <tr>
    <td><div class='style2'>JAWATAN</div></td>
    <td><div class='style2'>:</div></td>
    <td><div class='style2'>".strtoupper($rows2['penyemak_jawatan'])."</div></td>
  </tr>
  <tr>
    <td><div class='style2'>NO. TELEFON</div></td>
    <td><div class='style2'>:</div></td>
    <td><div class='style2'>".$rows2['penyemak_no_tel_pej']."</div></td>
  </tr>
  <tr>
    <td><div class='style2'>NO. H/P</div></td>
    <td><div class='style2'>:</div></td>
    <td><div class='style2'>".$rows2['penyemak_no_hp']."</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table></strong>";

$dihantar_kepada="<strong><table width=100% border=0>
<tr>
    <td width=30%><div class='style2'>DIHANTAR KEPADA</div></td>
    <td width=2%><div class='style2'>:</div></td>
    <td><div class='style2'>".strtoupper($dihantar_kepada_String)."</div></td>
  </tr>
  <tr>
    <td><div class='style2'>JAWATAN</div></td>
    <td><div class='style2'>:</div></td>
    <td><div class='style2'>".strtoupper($rows2['pengesah_jawatan'])."</div></td>
  </tr>
  <tr>
    <td><div class='style2'>NO. TELEFON</div></td>
    <td><div class='style2'>:</div></td>
    <td><div class='style2'>".$rows2['pengesah_no_tel_pej']."</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 </table></strong>";

$disahkan="<strong><table width=100% border=0>
<tr>
   <td width=30%><div class='style2'>DISAHKAN OLEH</div></td>
    <td width=2%><div class='style2'>:</div></td>
    <td><div class='style2'>".strtoupper(stripslashes($rows4['nama']))."</div></td>
  </tr>
  <tr>
    <td><div class='style2'>JAWATAN</div></td>
    <td><div class='style2'>:</td>
    <td><div class='style2'>".strtoupper($rows4['jawatan'])."</div></td>
  </tr>
  <tr>
    <td><div class='style2'>NO. TELEFON</div></td>
    <td><div class='style2'>:</div></td>
    <td><div class='style2'>".$rows4['telefon']."</div></td>
  </tr>

</table></strong>";
$mpdf->WriteHTML($disediakan);
//$mpdf->Ln(1.5);
$mpdf->WriteHTML($disemak);
//$mpdf->Ln(1.5);
$mpdf->WriteHTML($dihantar_kepada); 
//$mpdf->Ln(1.5);
if($status==9)
{
$mpdf->WriteHTML($disahkan);
}

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