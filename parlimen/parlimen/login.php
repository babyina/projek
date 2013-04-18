<html>
<head>
<title>Sistem Maklumbalas Parlimen & Jemaah Menteri</title>
<link rel="stylesheet" href="style.css" id="style">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript">
		var uid = "";
		var loginId = "";
		
		function validate(){	
			alert(uid);	
			if(document.forms[0].userid.value != uid){
				alert("Id anda tidak sepadan dengan kunci");
				return false;
				window.close();
			}else return true;
			
		}
		function constructLogin(){
			document.getElementById("login").innerHTML = loginId;
		}
</script>
</head>

<body bgcolor="#FFFFFF">
	<center><img src="images/logo1.jpg"/><br/>
	</center>
<br/><br/><br/><br/>
<basefont size="2">
<table width="100%">
  <tr>
    <td width="983" height="300" align="center" valign="middle"> 
	<form name="_login" action="authenticate.php" method="POST">
        <table width="543" border="0" cellpadding="0" cellspacing="0" align="center">
          <?php
		  /*
			$mode = isset($_GET['mode'])?$_GET['mode']:"";
			$syst = isset($_GET['syst'])?$_GET['syst']:"";
			$id = isset($_GET['id'])?$_GET['id']:"";
			isset($_GET['action'])?$_GET['action']:"";
			echo("<input type=\"hidden\" name=\"mode\" value=".$mode.">");
			echo("<input type=\"hidden\" name=\"id\" value=".$id.">");
			echo("<input type=\"hidden\" name=\"syst\" value=".$syst.">");
			echo("<input type=\"hidden\" name=\"action\" value=".$action.">");
			*/
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
			//echo("<input type=\"hidden\" name=\"action\" value=".$action.">");
	  ?>
          
		  <tr>
            <td height="16" colspan="3" align="center" valign="middle" class="header"><div><img src="images/welcome2.gif"/></div></td>
		  </tr>		

		  <tr>
			<td colspan="3">
				<div align="center">
				  <table border="0" width="96%">
					  <tr>
					    <td width="34%" rowspan="4"><img src="images/login.png"/></td>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
				    </tr>
					  <tr>
					    <td><strong><font color="#000000" size="2">ID Pengguna</font></strong></td>
					    <td><input name="userid" type="text" id="userid" maxlength="30" size="30"></td>
				    </tr>
					  <tr>
					    <td><strong><font color="#000000" size="2">Katalaluan</font></strong></td>
					    <td><input name="password" type="password" id="password" maxlength="10" size="30"></td>
				    </tr>
					  <tr><td width="21%" height="73">&nbsp;</td>
				      <td width="45%"><div id="login" name="login">
			            <div align="left">
			              <input class="button" name="login" type="submit" id="login" value="Masuk">
                          <input name="login2" type="submit" id="login2" value="Tukar Katalaluan" class="button">
                          <input name="login3" type="button" id="login3" value="Pendaftaran Baru" onClick="window.open('pendaftaran.php','test','width=700,height=350,true')" class="button">
                          <input name="login4" type="submit" id="login4" value="Keluar" onClick="window.close()" class="button">
			            </div>
				      </div></td></tr>
				  </table>
		    </div></td>
		  </tr>
		     
		  <tr>
		    <td colspan="3" align="center">&nbsp;</td>
	      </tr>
		  <tr><td colspan="3" align="center">
		  <table border="1">
		    <tr>
		      <td width="460" align="center"><div align="center"><b>Untuk Pertanyaan</b></div></td>
		      </tr>
		    <tr>
		      <td><div align="center">Sistem Pengesanan Soal Jawab Parlimen</div></td>
		      </tr>
		  <tr><td><table border="0">
					<tr>
					  <td width="68">Nama</td>
					  <td width="10">:</td>
					  <td width="368">Wan Fahirusyah </td>
					  </tr>
					<tr>
					  <td>Jawatan</td>
					  <td>:</td>
					  <td>Pegawai Setiausaha</td>
					  </tr>
					<tr>
					  <td>No. Tel</td>
					  <td>:</td>
					  <td>03-8889 7878</td>
					  </tr>
					<tr>
					  <td>Emel</td>
					  <td>:</td>
					  <td>jamlee.yanggitom@treasury.gov.my</td>
					  </tr>
					</table>
				</td>          
		  </table>
		  </td></tr>		  
		  
        </table>
      </form></td>
  </tr>
</table>
<?php
include("footer_login.php");
?>
