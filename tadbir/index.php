    <?php
		$valid = $_GET['valid']; 

		if ($valid){
			echo "<script> alert(\"ID Pengguna dan Katalaluan tidak sepadan \"); </script>";
			$valid = "true";
		}

	?>

<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Sistem Pentadbiran Soal Jawab Parlimen</title>
<link rel="stylesheet" href="style.css" id="style"> 
<SCRIPT LANGUAGE="JavaScript" SRC="function.js"></SCRIPT>
</head>

<body  style="margin-top:50px" onLoad="document.login.userid.focus()">
<table  align="center" width="900" border="1" cellpadding="0" cellspacing="0" >
    <tr> 
    <td width="100%" height="102" valign="top">
	<center><img src="images/banner/banner2.png"/> 
	</center>
	</td>
  </tr>
  <tr> 
     <td align="center" height="227" width="100%" style="background:url(images/banner/bg2.png); background-repeat:no-repeat; background-position:top; height:227"> 
    <div style="height:227; width:716">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
        <tr>
          <td width="80%">
		  	<form name="login" action="ldap_auth_2.php" method="POST"> 
          <?php			
			$mode = isset($_GET['mode'])?$_GET['mode']:"";$syst = isset($_GET['syst'])?$_GET['syst']:"";
			$id = isset($_GET['id'])?$_GET['id']:"";isset($_GET['action'])?$_GET['action']:"";
			echo("<input type=\"hidden\" name=\"mode\" value=".$mode.">");
			echo("<input type=\"hidden\" name=\"id\" value=".$id.">");
			echo("<input type=\"hidden\" name=\"syst\" value=".$syst.">");
			echo("<input type=\"hidden\" name=\"action\" value=".$action.">");
	  ?>
		  <table width="98%" border="0">
  <tr>
    <td height="58" >&nbsp;    </td>
    <td  colspan="2">
      <br /> <br /><center>
        <strong>.: SISTEM PENTADBIRAN :.</strong>
      </center></td>
  </tr>
  <tr>
    <td width="45%" >&nbsp;</td>
    <td width="16%"><strong>ID </strong></td>
    <!--<td width="39%"><input class="txt" name="userid" type="text" id="userid" maxlength="20" size="20" onMouseUp="number_only(this,event);"  onKeyPress="number_only(this,event);"></td>-->
    <td width="39%"><input class="txt" name="userid" type="text" id="userid" maxlength="12" size="12" ></td>-->
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Katalaluan</strong></strong></td>
    <td><input class="txt" name="password" type="password" id="password" size="20"  maxlength="20"></td>
  </tr>
 
  <tr>
    <td height="36" >&nbsp;</td>
    <td>&nbsp;</td>
    <td>
	<div align="left" >
        <input class="button" name="login" type="submit" id="login" value="Masuk">
	</div>
	
	<div align="right" style="font-size:9px"></div>	</td>
  </tr>
     <tr>
    <td>&nbsp;</td>
    <td colspan="2">
	<!--<font SIZE=2 color="red">  Sila gunakan  katalaluan email perbendaharaan </font> -->
    </td>
  </tr>
</table>
          </form>    </td>
          <td width="20%" ><p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
           <!-- <p>versi 2.1</p>--></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td ></td>
        </tr>
      </table>
      </div>    </td>
  </tr>
  <tr>
	<td height="1"><?php include("footer.php") ?> </td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <!--<tr>
    <td height="1"><br /><br />
	<center><strong>Untuk Pertanyaan </strong></center>	<br />
	<center>
	  Administrator    ::   Urusetian Penyelarasan Parlimen KKM ::   03-8883 2440    ::    ssjp@moh.gov.my
	</center>
	</td>
  </tr>-->	
</table>
<br /><br />

</body>
</html>