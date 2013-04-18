
<?php
include("../config.php");
include("../keyword.php");
 
$id = $_GET['id'];

$qry = "SELECT id,korperat_tambahan FROM parlimen WHERE id='$id'";
$result = mysql_query($qry,$conn);

$row = mysql_fetch_array($result);
$paparan = $row['korperat_tambahan'];

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Maklumat Tambahan dari HEK</title>
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../popcalendar.js"></script>
	<SCRIPT LANGUAGE="JavaScript" SRC="../function.js"></SCRIPT>
		<!-- Include the MULTI_UPLOAD function  -->
	<script src="../../multifile_compressed.js"></script>
</head>

<body bgcolor="#e7efff"><br><br>
<p><font class="agen"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Maklumat Tambahan dari HEK</strong></font></p>
<center>
  <textarea name="jawapan" cols="110" rows="40"><?php echo $paparan ?></textarea><br>
</center>
</body>
</html>
