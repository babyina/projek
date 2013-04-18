<?php
include("../config.php");
include('../keyword.php');
?>
<html>
<head>
<title>Sistem Maklumbalas Parlimen</title>
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../popcalendar.js"></script>
	<!--<SCRIPT LANGUAGE="JavaScript" SRC="../lw_layers.js"></SCRIPT>-->
<!--	<SCRIPT LANGUAGE="JavaScript" SRC="../lw_menu.js"></SCRIPT> -->
	
	<SCRIPT LANGUAGE="JavaScript" SRC="../function.js"></SCRIPT>
		<!-- Include the MULTI_UPLOAD function  -->
	<script src="multifile_compressed.js"></script>
</head>
	<body>
	<?
	$userid = $_SESSION['userid'];
	$isPengurusan = $_SESSION['pengurusan'];
	$agensi_id = $_SESSION['agensi_id'] ;
	//$jabatan = $_SESSION['jabatan'];
	if($isPengurusan)
		$qry = "SELECT parlimen.id FROM parlimen WHERE Status = 4";
	else
		$qry = "SELECT parlimen.id FROM parlimen,parlimen_agensi,pengguna 
		WHERE (parlimen.Status =2 OR parlimen.Status=3) 
		AND parlimen.id = parlimen_agensi.parlimen_id
		AND pengguna.Jabatan = parlimen_agensi.Jabatan AND pengguna.Jabatan = '$jabatan' AND pengguna.Id = '$userid'";
	
	//$result = mysql_query($qry,$conn) or die(mysql_error());
	//if(mysql_num_rows($result)>0){
	?>
	<tr><td class="m_item">&nbsp;<img src="../images/b4.gif"/><a style="<?php echo menuClick($_GET['view'],"Perhatian") ?>"href="index.php?action=list&view=perhatian">Untuk Perhatian</a>&nbsp;&nbsp;<img src="../images/baru.gif"/></td></tr>
	</body>
</html>