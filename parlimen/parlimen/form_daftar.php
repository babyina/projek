<?php
	
	function print_red($text){
		print "<font color=\"red\"><strong>" . $text . "</strong></font>";
	}
	?>
<html>
<head>
<title>Sistem Pengesanan Soal Jawab parlimen</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="style.css">
	<SCRIPT LANGUAGE="JavaScript" SRC="function.js"></script>
</head>
<body bgColor="#E0EEEE"><br><br>
	<?php
		if($show_form){
			$sistem = "Sistem Pengesanan Soal Jawab parlimen";

	?>
	<fieldset><legend>Pendaftaran Pengguna</legend>
	<form action="" method="post">
	<table width="100%">
	<tr height="20px">
	  <td colspan="4"><font class="fs">Sila lengkapkan medan bertanda (*) </font></td>
	  </tr>
	<tr height="20px">
		<td width="26%">Nama Sistem</td>
		<td width="3%">&nbsp;</td>
		<td width="1%">:</td>
		<td width="70%"><?php echo $sistem ?>
          <input name="sistem" type="hidden" value="<?php echo $sistem ?>"></td>
	</tr>
	<tr height="20px">
		<td>Nama</td>
		<td><?php print_red("*") ?></td>
		<td>:</td>
		<td><input name="Nama2" class="txt" size="50" onBlur="copyNama()" value="<?php echo $nama ?>"></td>
	</tr>
	<tr height="20px">
		<td>Agensi / Bahagian Kementerian Kesihatan</td>
		<td><?php print_red("*") ?></td>
		<td>:</td>
		<td>
		<select name="agensi_id">
		<?php
			$sel = mysql_query("SELECT id, nama FROM agensi ORDER BY id");
			while($row = mysql_fetch_array($sel)){
				$idAgensi = $row['id'];
				$namaAgensi = $row['nama'];
				print "<option value=\"" . $idAgensi . "," . $namaAgensi . "\">" . $namaAgensi . "</option>";
			}
		?>
		</select>		</td>
	</tr>
	<tr height="20px">
		<td>Jawatan</td>
		<td><?php print_red("*") ?></td>
		<td>:</td>
		<td><input name="jawatan" class="txt" size="50" value="<?php echo $jawatan ?>"></td>
	</tr>
	<tr height="20px">
		<td>No Telefon</td>
		<td><?php print_red("*") ?></td>
		<td>:</td>
		<td><input type="text" onBlur="checkNumeric(this,'','','','','');" name="Code" class="txt" size="3" maxlength="3" value="<?php echo phone_num($telefon,0); ?>"/>
		-
		<input name="Telefon" onBlur="checkNumeric(this,'','','','','');" class="txt" size="15" value="<?php echo phone_num($telefon,1); ?>"></td>
	</tr>
	<tr height="20px">
		<td>No Telefon Bimbit </td>
		<td>&nbsp;</td>
		<td>:</td>
		<td><input type="text" onBlur="checkNumeric(this,'','','','','');" name="Pre_num" class="txt" size="3" maxlength="3" value="<?php echo phone_num($handphone,0); ?>"/>
		  -  <input name="Handphone" onBlur="checkNumeric(this,'','','','','');" class="txt" size="15" value="<?php echo phone_num($handphone,1); ?>"></td></tr>
	<tr height="20px">
		<td>Emel</td>
		<td><?php print_red("*") ?></td>
		<td>:</td>
		<td><input name="emel" class="txt" size="30" value="<?php echo $emel ?>"></td>
	</tr>
	<tr height="20px">
		<td>ID Pengguna</td>
		<td><?php print_red("*") ?></td>
		<td>:</td>
		<td><input name="IDnama" class="txt" size="30" value="<?php echo $idUser ?>"></td>
	</tr>
	<tr height="20px">
		<td>Katalaluan</td>
		<td><?php print_red("*") ?></td>
		<td>:</td>
		<td><input name="pwdUser1" type="password" class="txt" size="30" value="<?php echo $pwdUser1 ?>"></td>
	</tr>
	<tr height="20px">
		<td>Pengesahan Katalaluan</td>
		<td><?php print_red("*") ?></td>
		<td>:</td>
		<td><input name="pwdUser2" type="password" class="txt" size="30" value="<?php echo $pwdUser2 ?>">
		<font color="red">(masukkan semula katalaluan)</font></td>
	</tr>
	<tr height="20px">
		<td>Tarikh Mendaftar</td>
		<td>&nbsp;</td>
		<td>:</td>
		<td><?php print date('d/m/Y'); ?></td>
	</tr>
	<tr><td colspan="4">
		<input type="submit" class="button" name="daftar" value="DAFTAR">
		<input type="button" class="button" value="TUTUP" onClick="window.close()">
	</td></tr>
	</table>
	</form>
	</fieldset>
	<?php
		}else{
	?>
	<fieldset>
	<legend>Pendaftaran Pengguna</legend>
	<table width="100%" align="center">
	<tr><td>&nbsp;</td></tr>
	<tr><td align="center"><?php echo $err_msg; ?></td></tr>
	</table>
	</fieldset>
	<?php
		}
	?>
</body>
</html>
