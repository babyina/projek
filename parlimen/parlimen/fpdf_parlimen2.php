<?php
session_cache_limiter('public');
session_start();

if (!isset($_SESSION['valid'])) {
	echo "Unauthorized User!";
	exit(0);
}

require('../config.php'); 
require('../keyword.php');
require('../fpdf/fpdf.php');
 

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



?>

<script language="javascript" type="text/javascript">
//function utk hidekan button/bahagian yang xnak print
function printPage() { 
if(document.all) { 
document.all.divButtons.style.visibility = 'hidden'; 
window.print(); 
document.all.divButtons.style.visibility = 'visible'; 
} else { 
document.getElementById('divButtons').style.visibility = 'hidden'; 
window.print(); 
document.getElementById('divButtons').style.visibility = 'visible'; 
} 
} 
</script> 

 

<script type="text/javascript"><!--
function hidestuffandprint(){
document.getElementById('header').style.display='none';
document.getElementById('footer').style.display='none';
document.getElementById('&p').style.display='visible';
setTimeout("print()",1000);
}

//-->
</script>

<style type="text/css">
<!--


body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}

body {
margin-top: 1.00;

}

/*
body {
	margin-left: 1.25in;
	margin-top: 1in;
	margin-right: 1.25in;
	margin-bottom: 1in;
}
*/
.style1 {font-size: 14pt;
         line-height: 1.5em;
		 font-family: Arial;
}

.style2 {font-size: 14pt; font-weight: bold; }


-->


</style>
<title>Jawapan Akhir</title>
<body>


<form>
  <div id="divButtons" name="divButtons" align="center"> 
    <input name="PrintButton" type="button" onClick="printPage();" value="Cetak"> 
  </div><div align="right" class="style1"> <strong>SOALAN NO:</strong><?php echo "&nbsp;"."<strong>".$no_soalan."</strong>" ?></div>
 </form>
 
<table width="100%" border="0" align="center">
 <!-- <tr>
    <td valign="top" width="184" class="style1">&nbsp;</td>
    <td valign="top" width="7" class="style1">&nbsp;</td>
    <td valign="top" width="100%" class="style1"><div align="right"><strong>SOALAN NO:</strong><?php echo $no_soalan ?></div>      </td>
  </tr>
  <tr>
    <td valign="top" colspan="3" class="style1">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" colspan="3" class="style1">&nbsp;</td>
  </tr>-->
  <tr>
    <td valign="top" colspan="3" class="style1"><div align="center"><strong>PEMBERITAHUAN PERTANYAAN <br>
    <?php echo strtoupper(($rows['sesi_dewan']==1)?"Dewan Rakyat":"Dewan Negara")?>, MALAYSIA <?php //if( $status!=9)
	//{echo "(DRAF)";}else{ echo "JAWAPAN AKHIR";}?></strong></div></td>
  </tr>
</table>
 <!--<hr align="center" width="100%" noshade class="style1">-->
 <table width="100%" border="0" align="center"> 
  <tr>
    <td valign="top" width="25%" class="style1"></td>
    <td valign="top" width="1%" class="style1">&nbsp;</td>
    <td  valign="top" width="74%" class="style2">&nbsp;</td>
  </tr>
  
    <tr>
    <td valign="top" class="style1"><div align="left"><strong>DARIPADA</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
	<td valign="top" class="style1"><div align="left"><strong><?php echo $gelarYB.' '.stripslashes($nama) ?></strong></div></td>
    
  </tr>
  
  
  <?php if ($nama_kawasan !="") { ?>
     
    <tr>
    <td valign="top" height="21" class="style1"><div align="left"><strong></strong></div></td>
    <td  valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong><?php echo "[".$nama_kawasan."]"?></strong></div></td>
  </tr>
  <?php } ?>
  <tr>
    <td valign="top" height="21" class="style1"><div align="left"><strong>PERTANYAAN</strong></div></td>
    <td  valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong><?php echo strtoupper($rows['bentuk_soalan'])?></strong></div></td>
  </tr>

  <?php if ($bentuk=="Lisan")  {?>
  <tr>
    <td  valign="top" class="style1"><div align="left"><strong>TARIKH</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong><?php echo date("d/m/Y",strtotime($rows['tkh_bentang_jawapan'])) ?></strong></div></td>
  </tr> 
  <?php } ?>  
 <!-- <tr>
    <td valign="top" class="style1"><div align="left"><strong>RUJUKAN</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
    <td valign="top" class="style1"><div align="left"></div></td>
  </tr>-->
  <tr>
    <td valign="top" class="style1">&nbsp;</td>
    <td valign="top" class="style1">&nbsp;</td>
    <td valign="top" class="style2">&nbsp;</td>
  </tr>

  <tr>
    <td valign="top" class="style1"><strong>SOALAN</strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" colspan="3" class="style1">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" colspan="3" class="style1" ><div align="justify"><?php echo $soalan ?></div></td>
  </tr>
</table> 
 

<!--<span class="style1"><br style="page-break-before:always;">
</span>-->
<table width="100%" border="0" align="center">

   <tr>
    <td valign="top" width="25%" class="style1"></td>
    <td valign="top" width="1%" class="style1">&nbsp;</td>
    <td  valign="top" width="74%" class="style2">&nbsp;</td>
  </tr>
    <tr>
    <td valign="top" width="25%" class="style1"></td>
    <td valign="top" width="1%" class="style1">&nbsp;</td>
    <td  valign="top" width="74%" class="style2">&nbsp;</td>
  </tr>
  <tr>
    <!--<td valign="top" width="297" class="style1"><strong>JAWAPAN</strong></td>-->
    <td valign="top" class="style1"><strong>JAWAPAN </strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" colspan="3" class="style1"><div align="justify"><?php echo $jawapan?></div></td>
  </tr>
</table>
  
  
<span class="style1"><br style="page-break-after:always;">
</span>
<table width="100%" border="0" align="center">
  <tr>
    <td valign="top" width="297" class="style1"><strong>MAKLUMAT TAMBAHAN </strong></td>
    <td valign="top" width="7" class="style1"><strong>:</strong></td>
    <td valign="top" width="896" class="style1">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="style1"><div align="justify"><?php echo $makTamb ?> </div></td>
  </tr>
  <tr>
    <td class="style1">&nbsp;</td>
    <td class="style1">&nbsp;</td>
    <td class="style1">&nbsp;</td>
  </tr>
  <tr>
    <td class="style1">&nbsp;</td>
    <td class="style1">&nbsp;</td>
    <td class="style1">&nbsp;</td>
  </tr>
</table>
  
  <span class="style1">
<?php
  
	$qry = "SELECT * FROM pengguna WHERE Nama='$created_by'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$temp = ((empty($row['telefon']))?" ":", ");
	
	  $qry2 = "SELECT * FROM parlimen_agensi WHERE parlimen_id ='$id'";
	mysql_select_db($db_voffice,$conn) or die(mysql_error());
     $result2 	= mysql_query($qry2,$conn) or die(mysql_error());

	$rows2 				= mysql_fetch_array($result2);
	$penyemak2 		= $rows2['disemak_oleh'];
	$penyemakjaw    = $rows2['penyemak_jawatan'];
	$notelpenyemak 		     = $rows2['penyemak_no_tel_pej'];
     

	
	?>
	
<br style="page-break-after:always;">	
  </span>
  <?php
  //pengesah nama  start here
  
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
	

  //end here
  
$SomeSpecialChars = array("�");
$ReplacementChars = array("'");
$Disemak_String = str_replace($SomeSpecialChars, $ReplacementChars, $rows2['disemak_oleh']);
$disediakan_String = str_replace($SomeSpecialChars, $ReplacementChars, $rows2['penyedia_nama']);
$dihantar_kepada_String = str_replace($SomeSpecialChars, $ReplacementChars, $rows2['pengesah_nama']);
  
  ?>
<table width="100%" border="0" align="center">
 <tr>
    <td valign="top" width="297" class="style1"><strong>DISEDIAKAN OLEH </strong></td>
    <td valign="top" width="10" class="style1"><strong>:</strong></td>
    <td valign="top" width="893" class="style1"><strong><?php echo strtoupper($disediakan_String)?></strong> </td>
  </tr>
  <tr>
    <td valign="top" class="style1"><strong>JAWATAN</strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style1"><strong><?php echo $rows2['penyedia_jawatan']?></strong></td>
  </tr>
  <tr>
    <td valign="top" class="style1"><strong>NO. TELEFON</strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style1"><strong><?php echo $rows2['penyedia_no_tel_pej'] ?></strong></td>
  </tr>
 <!-- <tr>
    <td valign="top" class="style1"><strong>TARIKH</strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style1"><?php echo DisplayDate($created_on)?></td>
  </tr>-->
  <tr>
    <td valign="top" class="style1">&nbsp;</td>
    <td valign="top" class="style1">&nbsp;</td>
    <td valign="top" class="style1">&nbsp;</td>
  </tr> 
  
<?php	

	$pengurusan_nama = addslashes($rows['pengurusan_nama']);
	$qry = "SELECT * FROM pengguna WHERE Nama='$pengurusan_nama'";
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$temp = ((empty($row['telefon']))?" ":", ");


 
 
?>  
  
  <tr>
    <td valign="top" class="style1"><strong>DISEMAK OLEH </strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style1"><strong><?php echo strtoupper($Disemak_String) ?></strong> </td>
  </tr>
  <tr>
    <td valign="top" class="style1"><strong>JAWATAN</strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style1"><strong><?php echo $rows2['penyemak_jawatan'] ?></strong></td>
  </tr>
  <tr>
    <td valign="top" class="style1"><strong>NO. TELEFON</strong></td>
    <td class="style1"><strong>:</strong></td>
    <td class="style1"><strong><?php echo $rows2['penyemak_no_tel_pej'] ?></strong></td>
  </tr>
  <tr>
    <td valign="top" class="style1"><strong>NO. H/P</strong></td>
    <td class="style1"><strong>:</strong></td>
    <td class="style1"><strong><?php echo $rows2['penyemak_no_hp'] ?></td>
  </tr>
 <!-- <tr>
    <td valign="top" class="style1"><strong>TARIKH</strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" valign="top" class="style1"><?php echo Reverse($rows['pengurusan_tarikh']) ?></td>
  </tr>-->
  <tr>
    <td valign="top" class="style1">&nbsp;</td>
    <td valign="top"  class="style1">&nbsp;</td>
    <td valign="top" class="style1">&nbsp;</td>
  </tr>
  <?php
  
  
  
$pengesahan_nama = addslashes($rows['pengesahan_nama']);  
$qry = "SELECT * FROM pengguna WHERE Nama='$pengesahan_nama'";
$result = mysql_query($qry,$conn) or die(mysql_error());
$row = mysql_fetch_array($result);

$temp = ((empty($row['telefon']))?" ":", ");
?>  
  
  <tr>
    <td valign="top" class="style1"><strong>DIHANTAR KEPADA</strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style1"><strong><?php echo strtoupper($dihantar_kepada_String)?></strong></td>
  </tr>
  <tr>
    <td valign="top" class="style1"><strong>JAWATAN</strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style1"><strong><?php echo $rows2['pengesah_jawatan']?></strong></td>
  </tr>
  <tr>
    <td valign="top" class="style1"><strong>NO. TELEFON </strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <!--<td valign="top" class="style1"><?//php echo $row2['pengesah_no_tel_pej']." ".$row2['pengesah_no_hp'] ?></td> asal-->
	<td valign="top" class="style1"><strong><?php echo $rows2['pengesah_no_tel_pej']?></strong></td
  ></tr>
<tr>

    <td valign="top" class="style1">&nbsp;</td>
    <td valign="top"  class="style1">&nbsp;</td>
    <td valign="top" class="style1">&nbsp;</td>

  </tr>
  
   <tr>
    <td valign="top" class="style1"><strong>DISAHKAN OLEH</strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style1"><strong><?php echo strtoupper(stripslashes($rows4['nama']))?></strong></td>
  </tr>
  <tr>
    <td valign="top" class="style1"><strong>JAWATAN</strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style1"><strong><?php echo strtoupper($rows4['jawatan'])?></strong></td>
  </tr>
  <tr>
    <td valign="top" class="style1"><strong>NO. TELEFON </strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <!--<td valign="top" class="style1"><?//php echo $row2['pengesah_no_tel_pej']." ".$row2['pengesah_no_hp'] ?></td> asal-->
	<td valign="top" class="style1"><strong><?php echo $rows4['telefon']?></strong></td>
	</tr>
  
</table>

<div id="divNoPrint1"></div>


</body>

