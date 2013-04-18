
<?php
include("../config.php");
include("../keyword.php");
 
$cid = $_GET['cid'];

$qry = "SELECT jawapan FROM sesi_bahas_detail WHERE ref_no='$cid'";
$result = mysql_query($qry,$conn);

$row = mysql_fetch_array($result);
$paparan = $row['jawapan'];

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Jawapan dari HEK</title>
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../popcalendar.js"></script>
	<SCRIPT LANGUAGE="JavaScript" SRC="../function.js"></SCRIPT>
		<!-- Include the MULTI_UPLOAD function  -->
	<script src="../../multifile_compressed.js"></script>
</head>

<body bgcolor="#e7efff"><br><br>
<p><font class="agen"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jawapan dari HEK</strong></font></p>
<center>
  <textarea name="jawapan" cols="110" rows="40"><?php echo $paparan ?></textarea><br>
</center>
</body>
</html>
