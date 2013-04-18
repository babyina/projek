<?php

$hostname_conn = "localhost";
$database_conn = "spmjmspsp";
$username_conn = "root";
$password_conn = "password";

$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
<?php
function terbalikkan_tarikh($tarikh_asal)
{if ($tarikh_asal!=""){
global $nilai1,$nilai2,$nilai3;
list ($nilai1, $nilai2, $nilai3) = split ('[/.-]', $tarikh_asal);
$nilai1=intval($nilai1);
$nilai2=intval($nilai2);
$nilai3=intval($nilai3);
if($nilai1<10){$nilai1="0".$nilai1;}
if($nilai2<10){$nilai2="0".$nilai2;}
if($nilai3<10){$nilai3="0".$nilai3;}
$tarikh_baru=$nilai3."-".$nilai2."-".$nilai1;
if($nilai1!="00" && $nilai2!="00" && $nilai3!="00")
{
return $tarikh_baru;
}
else
{
return "-";
}
}
}

$Carian = $_GET['Carian'];
$datesearch=terbalikkan_tarikh($Carian);
$tajuk= $_GET['title'];
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_record_1 = 5;
$pageNum_record_1 = 0;
if (isset($_GET['pageNum_record_1'])) {
  $pageNum_record_1 = $_GET['pageNum_record_1'];
}
$startRow_record_1 = $pageNum_record_1 * $maxRows_record_1;

mysql_select_db($database_conn, $conn);
//$query_record_1 = "SELECT * FROM senarai_soalan_jawapan WHERE match(ISP_R_Soalan,ISP_R_Tambahan,ISP_R_TeksJawapan,ISP_T_Parti,ISP_T_Tanya,ISP_K_Sesi) against('$Carian' IN BOOLEAN MODE)";

if ($tajuk=="C2")
{
$query_record_1 = "SELECT * FROM senarai_soalan_jawapan WHERE ISP_D_TkhMesy LIKE '%".$Carian."%'";
}
if ($tajuk=="C4")
{
$query_record_1 = "SELECT * FROM senarai_soalan_jawapan WHERE ISP_D_TkhMesy LIKE '%".$datesearch."%'";
}
else
{
$query_record_1 = "SELECT * FROM senarai_soalan_jawapan WHERE ISP_R_Soalan LIKE '%".$Carian."%'or ISP_R_Tambahan LIKE '%".$Carian."%' or ISP_R_TeksJawapan LIKE '%".$Carian."%' or ISP_T_Parti LIKE '%".$Carian."%' or ISP_T_Tanya LIKE '%".$Carian."%' or ISP_K_Sesi LIKE '%".$Carian."%'";
}
//echo $query_record_1;
$query_limit_record_1 = sprintf("%s LIMIT %d, %d", $query_record_1, $startRow_record_1, $maxRows_record_1);
$record_1 = mysql_query($query_limit_record_1, $conn) or die(mysql_error());
$row_record_1 = mysql_fetch_assoc($record_1);

if (isset($_GET['totalRows_record_1'])) {
  $totalRows_record_1 = $_GET['totalRows_record_1'];
} else {
  $all_record_1 = mysql_query($query_record_1);
  $totalRows_record_1 = mysql_num_rows($all_record_1);
}
$totalPages_record_1 = ceil($totalRows_record_1/$maxRows_record_1)-1;

$queryString_record_1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_record_1") == false && 
        stristr($param, "totalRows_record_1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_record_1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_record_1 = sprintf("&totalRows_record_1=%d%s", $totalRows_record_1, $queryString_record_1);

?>
<link rel="stylesheet" href="../parlimen/style.css"> 
<?php if($totalRows_record_1 > 0 AND $Carian != NULL){?>
<?php do { ?>
  <table width="100%" border="0" cellspacing="0" bordercolor="#FF0000">
    <tr>
      <td colspan="3" bgcolor="#CC9900"><span style="font-weight: bold; color: #FFFFFF">MAKLUMAT SOALAN</span></td>
    </tr>
    <tr>
      <td colspan="3">
</td>
    </tr>
    <tr>
      <td width="24%">Bil</td>
      <td width="2%"><strong>:</strong></td>
      <td width="74%">&nbsp;<?php echo ($startRow_record_1++ + 1) ?></td>
    </tr>
    <tr>
      <td>Sesi</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_K_Sesi']; ?></td>
    </tr>
    <tr>
      <td>Mesyuarat</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_Mesy']; ?></td>
    </tr>
    <tr>
      <td>Penggal</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_Penggal']; ?></td>
    </tr>
    <tr>
      <td>Parlimen</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_Parlimen']; ?></td>
    </tr>
    <tr>
      <td>Tarikh Bersidang</td>
      <td><strong>:</strong></td>
      <td><?php echo DisplayDate($row_record_1['ISP_D_TkhMesy']); ?> Hingga <?php echo DisplayDate($row_record_1['ISP_D_TkhMesy1']); ?></td>
    </tr>
    <tr>
      <td>Tarikh Soalan Dijadualkan</td>
      <td><strong>:</strong></td>
      <td><?php echo DisplayDate($row_record_1['ISP_D_TerimaSoalan']); ?></td>
    </tr>
    <tr>
      <td>Nama Ahli Parlimen</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_Tanya']; ?></td>
    </tr>
    <tr>
      <td>Kawasan Parlimen</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_Kawasan']; ?></td>
    </tr>
    <tr>
      <td>Parti Diwakili</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_Parti']; ?></td>
    </tr>
    <tr>
      <td>Untuk Tindakan (Bahagian)</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_K_Bahagian']; ?></td>
    </tr>
    <tr>
      <td>Bentuk Soalan</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_K_Bentuk']; ?></td>
    </tr>
    <tr>
      <td>Telah Dibentangkan Di Parlimen</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['Bentang']; ?></td>
    </tr>
    <tr>
      <td>No. Soalan</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_No_Soalan']; ?></td>
    </tr>
    <tr>
      <td>Soalan</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_R_Soalan']; ?></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#CC9900"><span style="font-weight: bold; color: #FFFFFF">MAKLUMAT JAWAPAN</span></td>
    </tr>
    <tr>
      <td>Disediakan Oleh</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_DisediakanOleh']; ?></td>
    </tr>
    <tr>
      <td>Jawatan</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['Jawatan']; ?></td>
    </tr>
    <tr>
      <td>Diluluskan Oleh </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;Setiausaha Bahagian</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['Setiausaha']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;YBMK</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['YBMK']; ?></td>
    </tr>
    <tr>
      <td>Jawapan</td>
      <td><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_R_TeksJawapan']; ?></td>
    </tr>
    <tr>
      <td>Maklumat Tambahan</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_R_Tambahan']; ?></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
	<tr>	
	<?php $pdf_old="rekod_lama_parlimen.php"; ?>
      <td colspan="3"  align="center">
	  	 <form name="pdf" method="post" action="<?php echo $pdf_old ?>" target="_blank">
		 <input type="hidden" name="idcetak" value="<?php echo $row_record_1['id']; ?>"/>
		 <input type="submit" name="cetak_rekod" value="Cetak">
	    </form>  
	  </td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#CC9900">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
	
  </table>
  <?php } while ($row_record_1 = mysql_fetch_assoc($record_1)); ?>
  <div align="right">
    <p> <a href="<?php printf("%s?pageNum_record_1=%d%s", $currentPage, 0, $queryString_record_1); ?>">First</a> | <a href="<?php printf("%s?pageNum_record_1=%d%s", $currentPage, min($totalPages_record_1, $pageNum_record_1 + 1), $queryString_record_1); ?>">Previous</a> | <a href="<?php printf("%s?pageNum_record_1=%d%s", $currentPage, min($totalPages_record_1, $pageNum_record_1 + 1), $queryString_record_1); ?>">Next</a> | <a href="<?php printf("%s?pageNum_record_1=%d%s", $currentPage, $totalPages_record_1, $queryString_record_1); ?>">Last</a></p>
    <p>Jumlah Rekod : <?php echo $totalRows_record_1 ?></p>
  </div>
<?php
mysql_free_result($record_1);
?>
<?php } else { echo "<center>Tiada rekod '".$Carian."' ditemui</center>"; }?>

