


<?php
//require('html2fpdf.php'); 



require('../config.php'); 
require('../keyword.php');
$id	= $_POST['id'];
ini_set("memory_limit","256M");


//$pdf=new HTML2FPDF();
//$pdf->AddPage();

/*echo "<style type=\"text/css\">
table
{
    border-width: 0 0 1px 1px;
   
   
}



</style>";


*/

/*
$html_2 = '
<style>



.style1 {FONT-SIZE: 12pt;
         line-height: 1.5em;
		 font-family:  Sans-Serif;
		 text-align: justify; 
}
.style2 {FONT-SIZE: 12pt;
         line-height: 1.5em;
		 font-family: Sans-Serif;
		 font-weight:bold;
		 text-align: justify; 
}

.style3{FONT-SIZE: 12pt;
         line-height: 12.5em;
		 font-family: Arial;
		
}

body,p,span,div,font,style {
 font-family: Sans-Serif;
 FONT-SIZE: 12pt;
 line-height: 1.5em; 
 text-align: justify;   }
</style>';
*/
//$dewan="DEWAN NEGARA";

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
	
include("../mpdf/mpdf.php");  
//include("../mpdf.php");
$current_time = date("d/m/Y");
$dewan = $_POST['Sesi'];
$lpbyrequest= $_POST['lpbyrequest'];
//$lpbyrequest=" $lpbyrequest ";
$lpbyrequest="$lpbyrequest";
//$lpbyrequest2=" (".$lpbyrequest.")"." "; 

$tarikh_mula = mysqlDate($_POST['TkhMulaBersidang']);
$mpdf=new mPDF(); 
$flag=0;
//$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 
$mpdf->SetDisplayMode('fullpage'); 
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list
//$mpdf->Cell(0,0,"NO SOALAN : $no_soalan",0,1,'R');
// LOAD a stylesheet
$stylesheet = file_get_contents('../mpdf/examples/mpdfstyletables.css');
/*++++ INSERT PAGE NUMBER start!++++*/
$mpdf->setHTMLFooter('<div align="center"><b><font size=3>{PAGENO} / {nbpg}</b></font></div>') ;
$mpdf->setHTMLFooter('<div align="center"><b><font size=3><i>{PAGENO} / {nbpg}</i></b></font></div>','E') ;
/*++++ INSERT PAGE NUMBER end!++++*/

$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->Ln(1.0);
//$mpdf->writeHTML($dewan); 

	   $qry_tmptbl = "CREATE TEMPORARY TABLE tbl_count 
	   (idagen VARCHAR(10))";
	    mysql_query($qry_tmptbl,$conn)or die(mysql_error());
		
		

		$cat = array("Bahagian Kementerian Kesihatan","Agensi");
		$agencies = array();
		$agencies_name = array();
		$agen_cari = array();
		$i = 0;
		foreach($cat AS $key)
		{		
			$re_agensi = mysql_query("SELECT agensi.id,nama FROM agensi WHERE kategori='$key'  ORDER BY id") or die (mysql_error());
			while($row_agensi = mysql_fetch_array($re_agensi))
			{
			 	$agencies[] = $row_agensi['id'];
				$agencies_name[] = $row_agensi['nama'];
				$agen_id = $row_agensi['id'];
				$where .= $or."parlimen_agensi.agensi_id LIKE '$agen_id' OR parlimen_agensi.agensi_id LIKE '%+$agen_id' OR parlimen_agensi.agensi_id LIKE '$agen_id+%' OR parlimen_agensi.agensi_id LIKE '%+$agen_id+%'";
				$or = " OR ";
			}
		}	
$tajuk="<div align='left'><strong><font size=3>PERKARA :</font>"."<font size=3 style=\"text-transform:uppercase\">".$lpbyrequest."</font></strong></div>";
$mpdf->writeHTML($tajuk);
//$mpdf->Ln(1.0); 
$table= "<table width=100% border=1>"; 
$mpdf->WriteHTML($table);

//GET ID FROM BAHAGAIAN
$qry_agensi="select  parlimen.agensi,parlimen.soalan from parlimen
             WHERE  parlimen.tkh_mula_bersidang = '$tarikh_mula' AND parlimen.sesi_dewan = '$dewan'
		     and parlimen.soalan like '%$lpbyrequest%' and parlimen.agensi  in (select agensi.id FROM agensi)
		     ORDER BY parlimen.agensi ASC";
			 $result_agen = mysql_query($qry_agensi) or die (mysql_error());
			 
             
			  while($rows_agen = mysql_fetch_array($result_agen))
					{
					 $soalan_agen  = $rows_agen['soalan'];
					  $agen_valid  = $rows_agen['agensi'];
					$soalan_agen= strip_tags($soalan_agen, '<p><a></p></a></span>');
					 $soalan_agen= preg_replace('/minta MENTERI KESIHATAN/', '',  $soalan_agen,1); 
					 
					 
					if (preg_match("/\b$lpbyrequest\b/i", $soalan_agen) )						
                      {
					  //$agen_cari[] = $rows_agen['agensi'];
						
					  	$sql_insert="insert into  tbl_count(idagen)
			            values('$agen_valid')";
                         mysql_query($sql_insert,$conn) or die(mysql_error());
						 
					  }	
					 	
					}

           $b = mysql_query("SELECT distinct idagen from  tbl_count  ORDER BY idagen") or die (mysql_error());
			while($row_agensi_r = mysql_fetch_array($b))
			{
			 	$agen_cari[] = $row_agensi_r['idagen'];
				
			}	

   
foreach($agen_cari as $agensi_id) // loop avery agensi- retrive kabinet_agensi
		{
		
		
			
		//$qry = "SELECT parlimen.id,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS tarikh,parlimen.perkara, parlimen_agensi.agensi_id,parlimen.no_soalan AS no_soalan
				//FROM parlimen, parlimen_agensi
				//WHERE (parlimen_agensi.agensi_id LIKE '$agensi_id' OR parlimen_agensi.agensi_id LIKE '%+$agensi_id' OR parlimen_agensi.agensi_id LIKE '$agensi_id+%' OR parlimen_agensi.agensi_id LIKE '%+$agensi_id+%') AND parlimen_agensi.parlimen_id = parlimen.id AND (YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' AND (parlimen.status!='44')  OR YEAR(parlimen.tkh_bentang_jawapan) = '$tahun_sebelum') $query_meet
				//ORDER BY parlimen.tkh_bentang_jawapan desc LIMIT $offset,$pgRow";
		//echo "<tr><td colspan=\"6\"><strong>".$agencies_name[$i]."</strong></td></tr>";
       // echo "<tr><td>$agensi_id</td></tr>";
	  // echo " </tr><tr><th width=\"10%\">Tarikh</th><th  width=\"50%\" >Soalan</th><th width=\"15%\">Nama YB</th><th  width=\"10%\">Parti</th><th  width=\"15%\">Kawasan</th>";

         $qry = "SELECT parlimen.soalan,parlimen.tkh_bentang_jawapan,parlimen.ahli_dewan_id,
		parlimen.no_soalan,parlimen.kawasan_id,parlimen.parti_id,
		ahli_parlimen.nama as namamp,parti.nama_pendek as namaparti,kawasan.nama as namakawasan FROM parlimen
		INNER JOIN ahli_parlimen ON parlimen.ahli_dewan_id  = ahli_parlimen.id
		INNER JOIN parti ON parlimen.parti_id   = parti.id
		INNER JOIN kawasan ON parlimen.kawasan_id  = kawasan.id
		WHERE parlimen.agensi = '$agensi_id' AND parlimen.tkh_mula_bersidang = '$tarikh_mula' AND parlimen.sesi_dewan = '$dewan'
		and parlimen.soalan like '%$lpbyrequest%' 
		ORDER BY parlimen.tkh_bentang_jawapan ASC";
      // echo  $qry 
	    $result = mysql_query($qry) or die (mysql_error());
		if((mysql_num_rows( $result ))<>0) {
		
        //echo "<tr><td colspan=\"6\"><strong>".getAgensi($conn,$agensi_id)."</strong></td></tr>";
		$agensi= "<tr><td colspan=\"6\"><strong><font size=3>".getAgensi($conn,$agensi_id)."</font></strong></td></tr>";
		
		$mpdf->WriteHTML($agensi);
		
       // echo "<tr><td>$agensi_id</td></tr>";
	  // echo " </tr><tr><th width=\"10%\">Tarikh</th><th  width=\"50%\" >Soalan</th><th width=\"15%\">Nama YB</th><th  width=\"10%\">Parti</th><th  width=\"15%\">Kawasan</th>";
	   
         $tajuk= " <tr><th width=\"10%\"><font size=3>Tarikh</font></th><th  width=\"50%\" ><font size=3>Soalan</font></th><th width=\"15%\"><font size=3>Nama YB</font></th><th  width=\"10%\"><font size=3>Parti</font></th><th  width=\"15%\"><font size=3>Kawasan</font></th></tr>";
         $mpdf->WriteHTML($tajuk);
		 while($rows = mysql_fetch_array($result))
					{
						$tkh_terima =  DisplayDate($rows['tkh_bentang_jawapan']);
						$soalan  = $rows['soalan'];
						$soalan_asal = $rows['soalan'];
						$namamp=$rows['namamp'];
						$namaparti=$rows['namaparti']; 

						$namakawasan =$rows['namakawasan'];
						//$soalan=$html_2."<div class='style1'><p align='justify'>".$soalan."</p></div>";
						//$soalan = preg_replace("/<table>/", "", $soalan); 
						//$soalan=preg_replace('/<td([^>]*)><table[^>]*><tbody[^>]*>.*<\/table><\/td><\/tbody>/', '', $soalan); 
                      $soalan= strip_tags($soalan, '<p><a></p></a></span>');
                      $soalan_asal=strip_tags($soalan_asal, '<p><a></p></a></span>'); 
					 // $str = 'abcdef abcdef abcdef'; 
					  // pattern, replacement, string, limit echo preg_replace('/abc/', '123', $str, 1); // outputs '123def abcdef abcdef' 
					  
					  
					   $key_one="minta Menteri Kesihatan";
					   $soalan= preg_replace('/minta MENTERI KESIHATAN/', '', $soalan,1); 
						
						//$soalan= preg_replace("/<td>/", "", $soalan); 
						 // $soalan = str_replace('<body', '',  $soalan); 
                         // $soalan = str_replace('</body', '',  $soalan);
						
						
				  $compareYear=substr($tkh_terima,0,5);
				  if($compareYear=="00/00")
					{
					$tkh_terima='Bertulis';
					}
					else
					{
					$tkh_terima=$tkh_terima;
					}
					
					if ( preg_match("/\b$lpbyrequest\b/i",$soalan) )						
                      {
					$column="<tr ><td align=justify><font size=3>$tkh_terima</font></td><td align=justify><font size=3>$soalan_asal</font></td><td align=justify><font size=3>$namamp</font></td><td align=justify><font size=3>$namaparti</font></td><td align=justify><font size=3>$namakawasan</font></td></tr>";
						//echo $column;
						 $mpdf->WriteHTML($column);
						 $flag=1;
					}	 
						
		}				

		$i++;
		unset($column);
		}
	
		
	   }	
	
	
$endtab="</table>";
$mpdf->WriteHTML($endtab);

  if ($flag==0)
  {
  $mpdf->Ln(2.0);
  $norecord="Tiada Rekod";
  $mpdf->WriteHTML($norecord);
  }


$mpdf->Output();
exit;

?>