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
//include("../config.php");
//include("../keyword.php");

include("../../fckeditor.php") ;

if($_GET["id"])
{
	$id=($_GET['id'])?$_GET['id']:$_POST['id'];
	$qry = "select * from parlimen where id='$id'";
	$result = mysql_query($qry) or die (mysql_error());
			
	$row = mysql_fetch_array($result);
	$soalan = $row['soalan'];
}
?>
<form id="soalan" name="soalan" method="post" >
<table width="100%" border="0">
 
   <tr>
  	<td width="6%">&nbsp;</td>
  	<td colspan="2"><input name="button" type="button" class="button" onclick="window.close()" value="TUTUP" />
		     <input class="button" type="submit" name="Submit" value="SIMPAN" onclick="window.opener.entry_form.Soalan.value = window.soalan.Soalan.value; window.close()"/><br /><br /></td>		
  </tr>
     <tr>
  	<td width="6%">&nbsp;</td>
  	<td colspan="2"><font class="agen"><strong>Sila masukkan soalan</strong></font></td>		
  </tr>
  <tr>
  	<td>&nbsp;</td><td colspan="2">
		<form action="sampleposteddata.php" method="post" target="_blank">
<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
$sBasePath = $_SERVER['PHP_SELF'] ;
$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
echo $sBasePath;
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->Value		= 'This is some <strong>sample text</strong>. You are using <a href="http://www.fckeditor.net/">FCKeditor</a>.' ;
$oFCKeditor->Create() ;
?>
			<br>
			<input type="submit" value="Submit">
		</form>

	
	</td>		
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
