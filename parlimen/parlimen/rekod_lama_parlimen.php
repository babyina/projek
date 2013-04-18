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

$id 				= $_POST['idcetak'];
$qry 				= "SELECT * FROM senarai_soalan_jawapan WHERE id='$id'";
mysql_select_db($db_voffice,$conn) or die(mysql_error());
$result 			= mysql_query($qry,$conn) or die(mysql_error());

$rows 				= mysql_fetch_array($result);
$sesi_dewan 		= $rows['ISP_K_Sesi'];
//$ahli_dewan 		= $rows['ahli_dewan_id'];
$no_soalan 			= $rows['ISP_No_Soalan'];
$bentuk=$rows['ISP_K_Bentuk'];
$kawasan =$rows['ISP_T_Kawasan'];
$nama=$rows['ISP_T_Tanya'];
$soalan=$rows['ISP_R_Soalan'];
$hari = findHari($rows['ISP_D_TerimaSoalan']);
/*$korperat_nama 		= addslashes($rows['korperat_nama']);
$korperat_jawatan 	= $rows['korperat_jawatan'];
$korperat_jawapan 	= strip_tags($rows['korperat_jawapan']);
$pengurusan_nama 	= addslashes($rows['pengurusan_nama']);
$pengurusan_jawatan	= $rows['pengurusan_jawatan'];
$pengesahan_nama	= addslashes($rows['pengesahan_nama']);
$pengesahan_jawatan = $rows['pengesahan_jawatan'];
$created_by 		= addslashes($rows['created_by']);
$created_on 		= $rows['created_on'];

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

*/

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
	font-size: 12px;
}
/*
body {
	margin-left: 1.25in;
	margin-top: 1in;
	margin-right: 1.25in;
	margin-bottom: 1in;
}
*/
.style1 {font-size: 12pt}
.style2 {font-size: 12pt; font-weight: bold; }


-->


</style>
<title>Jawapan Akhir</title>
<body>


<form>
  <div id="divButtons" name="divButtons" align="center"> 
    <input name="PrintButton" type="button" onClick="printPage();" value="Cetak"> 
  </div>
</form>
<table width="100%" border="0" align="center">
  <tr>
    <td valign="top" width="184" class="style1">&nbsp;</td>
    <td valign="top" width="7" class="style1">&nbsp;</td>
    <td valign="top" width="100%" class="style1"><div align="right"><strong>SOALAN NO:</strong><?php echo $no_soalan ?></div>      </td>
  </tr>
  <tr>
    <td valign="top" colspan="3" class="style1">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" colspan="3" class="style1">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" colspan="3" class="style1"><div align="center"><strong>PEMBERITAHUAN PERTANYAAN <br>
    <?php echo strtoupper(($rows['ISP_K_Sesi']=="DEWAN RAKYAT")?"DEWAN RAKYAT":"DEWAN NEGARA")?>, MALAYSIA </strong></div></td>
  </tr>
</table>
 <hr align="center" width="100%" noshade class="style1">
 <table width="100%" border="0" align="center"> 
  <tr>
    <td valign="top" width="25%" class="style1"></td>
    <td valign="top" width="1%" class="style1">&nbsp;</td>
    <td  valign="top" width="74%" class="style2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" height="21" class="style1"><div align="left"><strong>PERTANYAAN</strong></div></td>
    <td  valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong><?php echo strtoupper($rows['ISP_K_Bentuk'])?></strong></div></td>
  </tr>
  <tr>
    <td valign="top" class="style1"><div align="left"><strong>DARIPADA</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
	<?php if ($kawasan =='') { ?>
    <td valign="top" class="style1"><div align="left"><strong><?php echo stripslashes($nama) ?></strong></div></td>
    <?php }else {  ?>
   <td valign="top" class="style1"><div align="left"><strong><?php echo stripslashes($nama).'('.$kawasan.')' ?></strong></div></td>
    
    <?php } ?>
  </tr>
  <?php if ($bentuk=="LISAN")  {?>
    <tr>
    <td  valign="top" class="style1"><div align="left"><strong>MESYUARAT</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong><?php echo $rows['ISP_T_Mesy']; ?></strong></div></td>
  </tr>
    <tr>
    <td  valign="top" class="style1"><div align="left"><strong>PENGGAL</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong><?php echo $rows['ISP_T_Penggal']; ?></strong></div></td>
  </tr>
    <tr>
    <td  valign="top" class="style1"><div align="left"><strong>PARLIMEN</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong><?php echo $rows['ISP_Parlimen']; ?></strong></div></td>
  </tr>
  <tr>
    <td  valign="top" class="style1"><div align="left"><strong>TARIKH BERSIDANG</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong><?php echo DisplayDate($rows['ISP_D_TkhMesy']); ?> Hingga <?php echo DisplayDate($rows['ISP_D_TkhMesy1']); ?></strong></div></td>
  </tr>
  <?php } ?>  
<tr>
    <td valign="top" class="style1"><div align="left"><strong>TARIKH SOALAN</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong>:</strong></div></td>
    <td valign="top" class="style1"><div align="left"><strong><?php echo $hari.', '.DisplayDate($rows['ISP_D_TerimaSoalan']) ?></strong></div></td>
  </tr>
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
    <td valign="top" colspan="3" class="style1"><div align="justify"><?php echo $soalan ?></div></td>
  </tr>
</table> 
 <span class="style1"><br style="page-break-before:always;">
</span>
<table width="100%" border="0" align="center">

  <tr>
    <td valign="top" width="297" class="style1"><strong>JAWAPAN</strong></td>
    <td valign="top" width="7" class="style1"><strong>:</strong></td>
    <td valign="top" width="896" class="style1">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" colspan="3" class="style1"><div align="justify"><?php echo $rows['ISP_R_TeksJawapan'];?></div></td>
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
    <td colspan="3" class="style1"><div align="justify"><?php echo $rows['ISP_R_Tambahan']; ?> </div></td>
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
<br style="page-break-after:always;">	
  </span>
<table width="100%" border="0" align="center">
 <tr>
    <td valign="top" width="297" class="style1"><strong>DISEDIAKAN OLEH </strong></td>
    <td valign="top" width="10" class="style1"><strong>:</strong></td>
    <td valign="top" width="893" class="style1"><?php echo $rows['ISP_T_DisediakanOleh'];?> </td>
  </tr>
  <tr>
    <td valign="top" class="style1"><strong>JAWATAN</strong></td>
    <td valign="top" class="style1"><strong>:</strong></td>
    <td valign="top" class="style1"><?php echo $rows['Jawatan'];?></td>
  </tr>
  </table>
<div id="divNoPrint1"></div>


</body> 

