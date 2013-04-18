<?php
session_start();
	include("config.php");
	
		$valid = $_GET['valid'];

		if ($valid){
			echo "<script> alert(\"ID Pengguna dan Katalaluan tidak sepadan\"); </script>";
			$valid = "true";
		}
//$idtest=$_GET['jns_kategori'];


//unset($_SESSION['jns_kategori']);
	?>
    
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Sistem Soal Jawab Parlimen</title>
<link rel="stylesheet" href="style.css" id="style">
<!--start function-->
<SCRIPT LANGUAGE="JavaScript" SRC="function.js"></SCRIPT>
<script language="javascript"> 

function login_ctrl()
{kategori=document.getElementById('kodkategori').value;
	switch(kategori)
	{
	
	case "1":
	document.getElementById('log_ctr').style.display="";
	document.getElementById('notify').style.display="";
	document.getElementById('notify2').style.display="none";
	document.getElementById('notify3').style.display="none";
	break;
	case "2":
	document.getElementById('log_ctr').style.display="";
	document.getElementById('notify').style.display="none";
	document.getElementById('notify2').style.display="none";
	document.getElementById('notify3').style.display="";
	break;
	case "3":
	document.getElementById('log_ctr').style.display="";
	document.getElementById('notify').style.display="none";
	document.getElementById('notify2').style.display="none";
	document.getElementById('notify3').style.display="";
	break;
	case "4":
	document.getElementById('log_ctr').style.display="";
	document.getElementById('notify').style.display="none";
	document.getElementById('notify2').style.display="none";
	document.getElementById('notify3').style.display="";
	break;
	case "5":
	document.getElementById('log_ctr').style.display="";
	document.getElementById('notify').style.display="none";
	document.getElementById('notify2').style.display="none";
	document.getElementById('notify3').style.display="";
	break;
	/*case "6":
	document.getElementById('log_ctr').style.display="";
	document.getElementById('notify').style.display="none";
	document.getElementById('notify2').style.display="none";
	break;
	case "7":
	document.getElementById('log_ctr').style.display="";
	document.getElementById('notify').style.display="none";
	document.getElementById('notify2').style.display="";
	break;*/
	}
}
</script>
<!--end function-->

<style type="text/css">
<!--
.style1 {font-size: 7pt}
-->
</style>
</head>

<body  style="margin-top:50px" onLoad="document.login.userid.focus()">
<table  align="center" width="900" border="1" cellpadding="0" cellspacing="0" >
    <tr> 
    <td width="100%" height="102" valign="top">
	<center><img src="images/banner/banner2.png"/>
	</center>	</td>
  </tr>
  <tr> 
    <td align="center" height="227" width="100%" style="background:url(images/banner/bg2.png); background-repeat:no-repeat; background-position:top; height:227"> 
    <div style="width:716">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" >
        <tr>
          <td width="80%" >
		  	<form name="login" action="checkLoginldap_email.php" method="POST">
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
    <td>&nbsp;    </td>
    <td  colspan="2" height="40">&nbsp;</td>
      <td width="22%">&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td width="15%"><strong>Kategori Pengguna</strong></td>
    <td id="log_ctr">
    
    <?php
	$quer = mysql_query("SELECT * FROM kategori order by kodkategori ASC");
	echo "<select id='kodkategori' name='kodkategori' onchange=\"login_ctrl()\"><option value=''>Sila Pilih Kategori</option>"; //onchange=\"login_ctrl\"
	while($noticia = mysql_fetch_array($quer))
	{
	if($noticia['kodkategori']==$_SESSION['kodkategori'])
		{
	echo "<option selected value='$noticia[kodkategori]'>$noticia[penerangan]</option>"."<BR>";
		}
	else
			{
	echo "<option value='$noticia[kodkategori]'>$noticia[penerangan]</option>";
			}
	}
	echo "</select>";
	?>
	
	<!--<select name="kategori" id="kategori" type="hidden">
		   <option value="">Sila Pilih Kategori</option>
				  <option value="1">Perbendaharaan</option>
				 <option value="2">Jabatan Akauntan Negara </option>
				  <option value="3">JPPH</option>
                   <option value="4">Unit eP</option>
				   <option value="5">Pinjaman Perumahan</option>
		      </select>   -->         </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="35%" >&nbsp;</td>
    <td width="15%"><strong>No                KP</strong></td>
    <td width="28%"><input class="txt" name="userid" type="text" id="userid" maxlength="12" size="12"  onMouseUp="number_only(this,event);"  onKeyPress="number_only(this,event);"></td>
     <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="25" >&nbsp;</td>
    <td><strong>Katalaluan</strong></strong></td>
    <td><input class="txt" name="password" type="password" id="password" size="12"></td>
     <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td >&nbsp;</td>
    <td height="30" colspan="2" align="center"  class="style1" id="notify" border="0" cellpadding="5" style="display:none">
<font SIZE=2 color="red">  Sila gunakan  katalaluan email perbendaharaan </font>
</td>
    <td>&nbsp;</td>
  </tr>
       
    <td colspan="4" align="center" id="notify2" style="display:none"></td> 
    
  <tr>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td>      
	<div align="left" style="width:195px">
        <input class="button" name="login" type="submit" id="login" value="Masuk">
	</div>
	<div align="center"><br>
	  </div>
	
		<div  align="left" id="notify3" style="display:none" ><a href="#" style="font-size:9px" onClick="window.open('change_password.php','test','width=700,height=200,true')">Tukar Katalaluan</a> </div>
	</td>
     <td>&nbsp;</td>
  </tr>
</table>
          </form>          </td>
        </tr>
      </table>
      </div>    </td>
  </tr>
  <tr>
	<td height="1" class="footer"><br/><center><strong>Untuk Pertanyaan </strong></center>	<br/>
 <?php
 if ($_SESSION['jns_kategori']==2)//notify3
{
echo "<script>document.getElementById('notify3').style.display='';</script>";
} 
else if ($_SESSION['jns_kategori']==1)
{
echo "<script>document.getElementById('notify').style.display='';</script>"; 
}
unset($_SESSION['jns_kategori']);


//--------- auto-generated from table pengguna ----------------------------------------------notify
     
	 //$query = "SELECT nama,jawatan,emel,telefon FROM pengguna WHERE roles LIKE '%3%' and modul1=1 LIMIT 1"; asal
	$query = "SELECT nama,jawatan,emel,telefon, handphone FROM pengguna WHERE roles LIKE '%3%' and modul1=1 and jawatan LIKE '%PSU%'";
	$result = mysql_query($query,$conn) or die(mysql_error());
	
	while($row=mysql_fetch_array($result))
	{
		$nama = $row['nama'];
		$jawatan = $row['jawatan'];
		$emel = $row['emel'];
		$telefon = $row['telefon'];
		$hp = $row['handphone'];
?>	
	
	<center>
	  <?php echo $nama ?>    ::   <?php echo $jawatan ?>   ::   <?php echo $telefon." / ".$hp ?>    
	</center>
	
<?php
 	}
	?>
	<center>
	<?php echo  "Emel :: urusetiaparlimen@tre.gov.my"; ?>
	</center>
	<br/>	</td>  
  </tr>
</table>
<br /><br />

</body>
</html>