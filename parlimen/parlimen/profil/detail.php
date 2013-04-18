<?php	
			
	$id = $_GET['id'];
	$qry = "SELECT ahli_parlimen.id,ahli_parlimen.sesi_dewan AS sesi,ahli_parlimen.nama AS nama_yb,ahli_parlimen.pangkat,
			ahli_parlimen.parti_id,parti.nama_pendek as parti,kawasan.nama as kawasan,ahli_parlimen.status
			FROM ahli_parlimen 
			LEFT JOIN kawasan ON kawasan.id = ahli_parlimen.kawasan_id
			LEFT JOIN parti ON parti.id = ahli_parlimen.parti_id
			WHERE ahli_parlimen.id ='$id'" ;
								
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$status = $row['status'];	
			
?>

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>PROFIL AHLI DEWAN RAKYAT <img src="../images/dot.gif"/></div>

<form name="detail" method="post">
<fieldset>
<div class="sub">
	<table border="0" width="100%">
		<tr><td width=144>Sesi</td><td width=15>:</td><td width=518>Dewan Rakyat<input type="hidden" name="Sesi" value="<?php echo $row['sesi'] ?>"/></tr>
		<tr><td width=144>Pangkat</td><td width=15>:</td><td width=518><?php echo $row['pangkat'] ?></tr>
		<tr><td width=144>Nama Y.B </td><td width=15>:</td><td width=518><?php echo $row['nama_yb'] ?></tr>
		<tr><td width=144>Kawasan Parlimen </td><td width=15>:</td><td width=518><?php echo $row['kawasan'] ?></td></tr>
		<tr><td width=144>Parti Diwakili </td><td width=15>:</td><td width=518><?php echo $row['parti'] ?></td></tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
</table>
</fieldset>
<p>
	<input type="hidden" name="ahli_parlimen_id" value="<?php echo $_GET['id'] ?>"/>
	<input type="submit" value="KEMASKINI" name="Edit" class="button" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; }?>/>
	<!--<input class="button" type="submit" value="KEMASKINI" name="Edit"/>-->
    <input type="button" name="delete" value="HAPUS" onClick="delDoc('rakyat','<?php echo $id;?>','')" class="button" <?php if($sys_acl!=1) echo 'disabled' ?>/>
</p>
</form>

<!--<?php
echo "<tr><td><form name=\"delete\" method=\"post\" action=\"index.php\" onSubmit=\"return verify()\">";
echo "<input type=\"submit\" value = \"HAPUS\" name=\"HapusRekod\" class=\"button\"/>";
echo "<input type=\"hidden\" name=\"id\" value=\"$id\"/>";
echo "</form><td></tr>";
?>-->




  
