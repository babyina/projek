<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../popcalendar.js"></script>
	<SCRIPT LANGUAGE="JavaScript" SRC="../function.js"></SCRIPT>
		<!-- Include the MULTI_UPLOAD function  -->
	<script src="multifile_compressed.js"></script>
<title>Kemasukan Soalan</title>
</head>

<body bgcolor="#e7efff"><br>
&nbsp;&nbsp;&nbsp;<br>
<?php
include("../config.php");
include("../keyword.php");

if($_GET["cid"])
{
	$cid=($_GET['cid'])?$_GET['cid']:$_POST['cid'];
	$qry = "select perkara from sesi_bahas_detail where ref_no='$cid'";
	$result = mysql_query($qry) or die (mysql_error());
			
	$row = mysql_fetch_array($result);
	$soalan = $row['perkara'];
}
?>
<form id="soalan" name="soalan" method="post" >
<table width="100%" border="0">
 
   <tr>
  	<td width="6%">&nbsp;</td>
  	<td colspan="2"><input name="button" type="button" class="button" onclick="window.close()" value="TUTUP" />
		     <input class="button" type="submit" name="Submit" value="SIMPAN" onclick="window.opener.berbangkit.Perkara.value = window.soalan.Soalan.value; window.close()"/><br /><br /></td>		
  </tr>
     <tr>
  	<td width="6%">&nbsp;</td>
  	<td colspan="2"><font class="agen"><strong>Sila masukkan soalan</strong></font></td>		
  </tr>
  <tr>
  	<td>&nbsp;</td><td colspan="2"></td>		
  </tr>
  <tr>
    <td>&nbsp;</td>	<td colspan="2">
		 <textarea name="Soalan" cols="100" rows="40"><?php echo $soalan ?></textarea><br /><br />

	</td>
 </tr>
</table>
</form>
</body>
</html>
