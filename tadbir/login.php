    <?php
		$valid = $_GET['valid'];

		if ($valid){
			echo "<script> alert(\"ID Pengguna dan Katalaluan tidak sepadan atau pengguna belum disahkan\"); </script>";
			$valid = "true";
		}

	?>

<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Sistem Perekodan & Maklum Balas Mesyuarat Jemaah Menteri</title>
<link rel="stylesheet" href="style.css" id="style">
</head>

<body style="margin-left:100px;margin-right:100px;margin-top:50px" onLoad="document.login.userid.focus()">
<table width="100%" border="1" cellpadding="0" cellspacing="0" height="311">
        <?php	
			
			$action = isset($_GET['action'])?$_GET['action']:"";
			$syst = isset($_GET['syst'])?$_GET['syst']:"";
			if($_GET['id']){
				$id = isset($_GET['id'])?$_GET['id']:"";
				echo("<input type=\"hidden\" name=\"id\" value=".$id.">");
			}
			if($_GET['cid']){
				$cid = isset($_GET['cid'])?$_GET['cid']:"";
				echo("<input type=\"hidden\" name=\"cid\" value=".$cid.">");
				}
			//echo $action.$id.$cid;
			//isset($_GET['action'])?$_GET['action']:"";
			echo("<input type=\"hidden\" name=\"action\" value=".$action.">");						
			echo("<input type=\"hidden\" name=\"syst\" value=".$syst.">");

	  ?>

    <tr> 
    <td width="100%" height="102" valign="top">
	<center><img src="images/logo1.jpg"/> <br/>
	</center>
	<br/><br/></td>
  </tr>
  <tr> 
    <td align="center" height="205" bgcolor="#7BC3F7"> 
    <div style="height:227; width:716">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" height="240" bgcolor="#7BC3F7">
        <tr>
          <td width="80%" height="240">
		  	<form name="login" action="authenticate.php" method="POST">
          <?php			
			$mode = isset($_GET['mode'])?$_GET['mode']:"";$syst = isset($_GET['syst'])?$_GET['syst']:"";
			$id = isset($_GET['id'])?$_GET['id']:"";isset($_GET['action'])?$_GET['action']:"";
			echo("<input type=\"hidden\" name=\"mode\" value=".$mode.">");
			echo("<input type=\"hidden\" name=\"id\" value=".$id.">");
			echo("<input type=\"hidden\" name=\"syst\" value=".$syst.">");
			echo("<input type=\"hidden\" name=\"action\" value=".$action.">");
	  ?>
		  <table width="100%" border="0">
  <tr>
    <td height="70">&nbsp;    </td>
    <td height="70" colspan="2"><br />
      <br /><center><strong>.: SISTEM PENTADBIRAN :.</strong></center></td>
  </tr>
  <tr>
    <td width="14%" height="33">&nbsp;</td>
    <td width="25%"><strong>ID
                Pengguna</strong></td>
    <td width="61%"><input class="txt" name="userid" type="text" id="userid" maxlength="30" size="30"></td>
  </tr>
  <tr>
    <td height="33">&nbsp;</td>
    <td><strong>Katalaluan</strong></strong></td>
    <td><input class="txt" name="password" type="password" id="password" maxlength="10" size="30"></td>
  </tr>
  <tr>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td>
	<div align="left">				
                  <input class="button" name="login" type="submit" id="login" value="Masuk">
				  <input name="login2" class="button" type="button" id="login2" value="Tukar Katalaluan" onClick="window.open('change_password.php','test','width=700,height=350,true')"><br />
                  <input name="login3" type="button" id="login3" value="Pendaftaran Baru" onClick="window.open('pendaftaran.php','test','width=700,height=650,true')" class="button">
				  <input name="login4" type="submit" id="login4" value="Keluar" onClick="window.close()" class="button">          
    </div>	</td>
  </tr>
</table>
          </form>          </td>
          <td width="20%" height="240" background="images/Imageparlimen.jpg">&nbsp;</td>
        </tr>
      </table>
      </div>    </td>
  </tr>
  <tr>
	<td height="1"><?php include("footer.php") ?> </td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td height="1"><br /><br />
	<center><strong>Untuk Pertanyaan </strong></center>	<br />
	<center>
	  Administrator   ::   Pegawai Sistem Maklumat   ::   03-8889 7841    ::    jamlee.yanggitom@treasury.gov.my
	</center>	
	</td>
  </tr>
</table>
<br /><br />

</body>
</html>