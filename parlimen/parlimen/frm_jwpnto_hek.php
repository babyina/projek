
<?php
include("../config.php");
include("../keyword.php");
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Jawapan dari <?php echo $name ?></title>
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../popcalendar.js"></script>
	<SCRIPT LANGUAGE="JavaScript" SRC="../function.js"></SCRIPT>
		<!-- Include the MULTI_UPLOAD function  -->
	<script src="../../multifile_compressed.js"></script>
</head>

<body bgcolor="#e7efff"><br><br>
<table width="100%" border="0">

<?php
if($_GET["cid"])
{
$cid=$_GET["cid"];
$qry = "SELECT bahas_agensi.agensi_id, jawapan, tambahan, keterangan_tambahan,agensi.nama 
		FROM bahas_agensi, agensi WHERE bahas_agensi.bahas_id='$cid' AND bahas_agensi.agensi_id=agensi.id";
$result = mysql_query($qry,$conn) or die (mysql_error());


while($row = mysql_fetch_array($result))
{
	$nama = $row['nama'];
	$tajuk = "Jawapan dari ".$nama;
	$jawapan = $row['jawapan'];
	$tambahan = $row['tambahan'];
	$keterangan_tambahan = $row['keterangan_tambahan'];

	$tambahan = (!empty($row['tambahan']))?"<tr><td></td><td> $tambahan</td><td></td></tr>":"";
	$keterangan_tambahan = (!empty($row['keterangan_tambahan']))?"<tr><td></td><td> $keterangan_tambahan</td><td></td></tr>":"";

	//$keterangan_tambahan = ((!empty($row['keterangan_tambahan']))?"<tr><td>&nbsp;</td><td> $row['keterangan_tambahan']</td><td>&nbsp;</td></tr>":"");
	//$keterangan_tambahan = $row['keterangan_tambahan'];


?>

  <tr>
    <td width="8%">&nbsp;</td>
    <td width="84%"><font class="agen"><strong><?php echo $tajuk ?></strong></font></td>
    <td width="8%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $jawapan  ?></td>
    <td>&nbsp;</td>
  </tr>
  <?php echo $tambahan  ?>
  <?php echo $keterangan_tambahan  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
<?php
}
	}
?>
</table>

</body>
</html>
