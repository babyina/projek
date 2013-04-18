
<?php
include("../config.php");
include("../keyword.php");
 
$id = $_GET['id'];

$qry = "SELECT id,soalan FROM parlimen WHERE id='$id'";
$result = mysql_query($qry,$conn);

$row = mysql_fetch_array($result);
$paparan = $row['soalan'];

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Paparan Soalan</title>
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../popcalendar.js"></script>
	<SCRIPT LANGUAGE="JavaScript" SRC="../function.js"></SCRIPT>
		<!-- Include the MULTI_UPLOAD function  -->
	<script src="../../multifile_compressed.js"></script>
</head>

<body bgcolor="#e7efff"><br><br>
<p><font class="agen"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Soalan</strong></font></p>
<center>
  <textarea name="jawapan" cols="110" rows="40" readonly><?php echo $paparan ?></textarea><br>
</center>
</body>
</html>
