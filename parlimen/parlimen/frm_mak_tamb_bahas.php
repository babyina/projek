
<?php
include("../config.php");
include("../keyword.php");
 
$jawapan_id = $_GET['jawapan_id'];
$id = $_GET['id'];
$name = $_GET['name'];


$qry = "SELECT id,bahas_id,tambahan FROM bahas_agensi WHERE id='$jawapan_id'  AND bahas_id='$id'";
$result = mysql_query($qry,$conn);

$row = mysql_fetch_array($result);
$paparan = $row['tambahan'];
$tajuk = "Maklumat Tambahan dari ".$name;

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Maklumat Tambahan dari <?php echo $name ?></title>
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../popcalendar.js"></script>
	<SCRIPT LANGUAGE="JavaScript" SRC="../function.js"></SCRIPT>
		<!-- Include the MULTI_UPLOAD function  -->
	<script src="../../multifile_compressed.js"></script>
</head>

<body bgcolor="#e7efff"><br><br>
<p><font class="agen"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $tajuk ?></strong></font></p>
<center>
  <textarea name="jawapan" cols="110" rows="40"><?php echo $paparan ?></textarea>
</center>
</body>
</html>
