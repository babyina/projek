<?php
$hostname_conn = "localhost";
$database_conn = "spmjmspsp";
$username_conn = "root";
$password_conn = "zaq12wsx";
$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
<?php
$Carian = $_GET['Carian'];

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_record_1 = 100;
$pageNum_record_1 = 0;
if (isset($_GET['pageNum_record_1'])) {
  $pageNum_record_1 = $_GET['pageNum_record_1'];
}
$startRow_record_1 = $pageNum_record_1 * $maxRows_record_1;

mysql_select_db($database_conn, $conn);
$query_record_1 = "SELECT * FROM senarai_soalan_jawapan";
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
<?php do { ?>
  <table width="100%" border="0" cellspacing="0" bordercolor="#FF0000">
    <tr>
      <td colspan="3" bordercolor="#CCCCCC" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%">Bil</td>
      <td width="2%"><strong>:</strong></td>
      <td width="74%">&nbsp;<?php echo ($startRow_record_1++ + 1) ?></td>
    </tr>
    <tr>
      <td>Bentang</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['Bentang']; ?></td>
    </tr>
    <tr>
      <td>Editor</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['Editor']; ?></td>
    </tr>
    <tr>
      <td>EditorDisplay</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['EditorDisplay']; ?></td>
    </tr>
    <tr>
      <td>ISP_D_TerimaSoalan</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_D_TerimaSoalan']; ?></td>
    </tr>
    <tr>
      <td>ISP_D_TkhMesy</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_D_TkhMesy']; ?></td>
    </tr>
    <tr>
      <td>ISP_D_TkhMesy1</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_D_TkhMesy1']; ?></td>
    </tr>
    <tr>
      <td>ISP_K_Bahagian</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_K_Bahagian']; ?></td>
    </tr>
    <tr>
      <td>ISP_K_Bentuk</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_K_Bentuk']; ?></td>
    </tr>
    <tr>
      <td>ISP_K_Sesi</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_K_Sesi']; ?></td>
    </tr>
    <tr>
      <td>ISP_No_Soalan</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_No_Soalan']; ?></td>
    </tr>
    <tr>
      <td>ISP_Parlimen</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_Parlimen']; ?></td>
    </tr>
    <tr>
      <td>ISP_R_Soalan</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_R_Soalan']; ?></td>
    </tr>
    <tr>
      <td>ISP_R_Soalan_1</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_R_Soalan_1']; ?></td>
    </tr>
    <tr>
      <td>ISP_R_Tambahan</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_R_Tambahan']; ?></td>
    </tr>
    <tr>
      <td>ISP_R_TeksJawapan</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_R_TeksJawapan']; ?></td>
    </tr>
    <tr>
      <td>ISP_R_TeksJawapan_1</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_R_TeksJawapan_1']; ?></td>
    </tr>
    <tr>
      <td>ISP_T_DisediakanOleh</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_DisediakanOleh']; ?></td>
    </tr>
    <tr>
      <td>ISP_T_DisediakanOleh_1</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_DisediakanOleh_1']; ?></td>
    </tr>
    <tr>
      <td>ISP_T_Kawasan</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_Kawasan']; ?></td>
    </tr>
    <tr>
      <td>ISP_T_Mesy</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_Mesy']; ?></td>
    </tr>
    <tr>
      <td>ISP_T_Parti</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_Parti']; ?></td>
    </tr>
    <tr>
      <td>ISP_T_Penggal</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_Penggal']; ?></td>
    </tr>
    <tr>
      <td>ISP_T_Tanya</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ISP_T_Tanya']; ?></td>
    </tr>
    <tr>
      <td>Jawatan</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['Jawatan']; ?></td>
    </tr>
    <tr>
      <td>Jawatan_1</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['Jawatan_1']; ?></td>
    </tr>
    <tr>
      <td>KemaskiniOleh</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['KemaskiniOleh']; ?></td>
    </tr>
    <tr>
      <td>LoginName</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['LoginName']; ?></td>
    </tr>
    <tr>
      <td>LoginTime</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['LoginTime']; ?></td>
    </tr>
    <tr>
      <td>Maklumat_Jawapan</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['Maklumat_Jawapan']; ?></td>
    </tr>
    <tr>
      <td>Maklumat_Soalan</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['Maklumat_Soalan']; ?></td>
    </tr>
    <tr>
      <td>Reader</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['Reader']; ?></td>
    </tr>
    <tr>
      <td>ReaderDisplay</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ReaderDisplay']; ?></td>
    </tr>
    <tr>
      <td>ScreenCode</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['ScreenCode']; ?></td>
    </tr>
    <tr>
      <td>Setiausaha</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['Setiausaha']; ?></td>
    </tr>
    <tr>
      <td>Soalan_Tambahan</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['Soalan_Tambahan']; ?></td>
    </tr>
    <tr>
      <td>TarikhKemaskini</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['TarikhKemaskini']; ?></td>
    </tr>
    <tr>
      <td>YBMK</td>
      <td width="2%"><strong>:</strong></td>
      <td><?php echo $row_record_1['YBMK']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
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
