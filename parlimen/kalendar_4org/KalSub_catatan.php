<?php
session_start();
if ($_SESSION['valid'] == false){
	echo "invalid session";	
	exit(0);
}else{
	if($_SESSION['timer']<>null){
		if(time() - $_SESSION['timer'] >90000000){
		//auto logout after 5 minute
			header("location:../auto_logout.php");
			exit(0);
		}	
	}
}

include("../config.php");
include("../keyword.php");
include("include/func.php");

//Get value
$id		= $_GET['id'];
$sql	= "SELECT Tarikh, Agensi, Catatan FROM kal_pegawaitugas WHERE Kal_pegawaiTugas_id='$id'";
$rs		= mysql_query($sql) or die(mysql_error());
$row	= mysql_fetch_array($rs);

if($_POST['simpan']){
	$catatan = $_POST['catatan'];
	$sqlCtn	= "UPDATE kal_pegawaitugas SET 
					Catatan='".$catatan."'
				WHERE Kal_pegawaiTugas_id='$id'";
	mysql_query($sqlCtn)or die(mysql_error());
	
	echo "<script language=\"JavaScript\" type=\"text/JavaScript\">";
	echo "	window.opener.location.reload();";
	echo "	window.close();";
	echo "</script>";
	exit();	
}
?>
<title>Pertanyaan Lisan / Isu Dibangkitkan</title>
<div style="font-family:Arial;font-size:9pt;font-weight:bold;text-align:center;margin-top:10px;height:40px">
<link rel="stylesheet" href="../style.css" title="general" type="text/css">
<body style="margin:5px">
<form action="" method="post">
	<fieldset>
		<legend>Pertanyaan Lisan / Isu dibangkitkan</legend>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="33%">Agensi</td>
            <td width="2%">:</td>
            <td width="65%"><?php echo $row['Agensi'];?></td>
          </tr>
          <tr>
            <td>Tarikh</td>
            <td>:</td>
            <td><?php echo reverse($row['Tarikh']);?></td>
          </tr>
          <tr>
            <td>Catatan</td>
            <td>:</td>
            <td><textarea id="catatan" rows="10" cols="55" name="catatan"><?php echo $row['Catatan'];?></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
    </table>
	<center><input type="submit" value="Simpan" name="simpan" tabindex="1" class="button"></center>
	</fieldset>
</form>
</body>