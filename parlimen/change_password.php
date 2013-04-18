<SCRIPT LANGUAGE="JavaScript" SRC="function.js"></SCRIPT>
<?php
require('config.php');
session_start();
$show_form_login = true;
$show_form_change = false;
$show_all = true;
$error = 0;
$check_login = $_GET['login'];
if(strlen($check_login) < 1){ $check_login = $_POST['login']; }
if($show_form_login){
	$check_login_name = "login";
	$check_login_value = "login";
}

if(isset($_POST['login_button'])){
	$login =mysql_escape_string(trim($_POST['idUser'])); 
	$password =mysql_escape_string(trim($_POST['pwdUser']));
	
	$sql = mysql_query("SELECT id_tbl FROM pengguna WHERE nokp = '$login' AND password = md5('$password')");
	if(mysql_num_rows($sql) > 0){
	    //$result = mysql_query($sql);
	    $row2 = mysql_fetch_array($sql);
		$show_all = true;
		$show_form_login = false;
		$check_login_name = "change";
		$check_login_value = "change";
		$_SESSION['session_login'] = 1;
		$_SESSION['userid'] = $login;
		$_SESSION['userid'] = $row2['id_tbl'];
	}else{
		$show_all = true;
		$show_form_login = true;
		$err_message = "No. KP dan Katalaluan tidak sepadan";
		session_destroy();
	}
}

if(isset($_POST['change_button'])){
	$pwd1 = $_POST['pwdUser1'];
	$pwd2 = $_POST['pwdUser2'];

	if($pwd1<>$pwd2){
		$show_all = true;
		$show_form_login = false;
		$err_message = "Katalaluan dan pengesahan katalaluan tidak sama";
		$error = 1;
	}
	
	if(strlen($pwd1) < 1 || strlen($pwd2) < 1){
		$show_all = true;
		$show_form_login = false;
		$err_message = "Masukkan katalaluan dan pengesahan katalaluan";
		$error = 1;
	}
	
	if($error < 1){
		$id = $_SESSION['userid'];
		$sql = mysql_query("UPDATE pengguna SET password = md5('$pwd2') WHERE id_tbl='$id'");
		
		$show_all = false;
	}
}

?>
<html>
<head>
<title>Sistem Soal Jawab Parlimen</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div align="center">
<fieldset style="width:80%">
<legend>Tukar Katalaluan</legend>
<form action="change_password.php" method="post">
<input type="hidden" name="<?php echo $check_login_name; ?>" value="<?php echo $check_login_value; ?>">
<?php
	if($show_all){
		if($show_form_login){
?>
			<table width="100%">
			<tr><td colspan="3" align="center"><font color="red"><?php echo $err_message; ?><br></font></td></tr>
			<tr height="20px">
				<td width="20%">No KP</td>
				<td width="2%">:</td>
				<td><input name="idUser" class="txt" size="12" maxlength="12" onMouseUp="number_only(this,event);"  onKeyPress="number_only(this,event);"></td>
			</tr>
			<tr>
				<td>Katalaluan</td>
				<td>:</td>
				<td><input type="password" name="pwdUser" size="12" class="txt"></td>
			</tr>
			<tr><td colspan="3">
			<input type="submit" value="HANTAR" class="button" name="login_button">
			<input type="button" value="KELUAR" class="button" onClick="window.close()">
			</td></tr>
			</table>
<?php
		}else{
			if($_SESSION['session_login'] > 0){
?>
			<table width="100%">
			<tr><td colspan="3" align="center"><font color="red"><?php echo $err_message; ?></font></td></tr>
			<tr height="20px">
			  <td><center></center></td>
			  <td>&nbsp;</td>
			  <td><font color="#0099CC">Sila masukkan Katalaluan baru</font></td>
			</tr>
			<tr height="20px">
				<td width="30%">Katalaluan Baru</td>
				<td width="2%">:</td>
				<td><input type="password" name="pwdUser1" size="12" class="txt"></td>
			</tr>
			<tr>
				<td>Pengesahan Katalaluan</td>
				<td>:</td>
				<td><input type="password" name="pwdUser2" size="12" class="txt"></td>
			</tr>
			<tr><td colspan="3">
			<input type="submit" value="HANTAR" class="button" name="change_button">
			<input type="button" value="KELUAR" class="button" onClick="window.close()">
			</td></tr>
			</table>
<?php
			}
		}
	}else{
		print 	"<table width=\"100%\">" .
				"<tr><td>Anda telah berjaya menukar katalaluan.</td></tr>" .
				"<tr><td>Sila guna katalaluan yang baru untuk menggunakan sistem ini.</td></tr>" .
				"<tr><td><a href=\"javascript: window.close();\">Keluar..</td></tr>" .
				"</table>";
	}
?>
</form>
</fieldset>
</div>
</body>
</html>
