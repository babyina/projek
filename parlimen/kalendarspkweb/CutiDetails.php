<?php
	$id = $_GET['id'];
	$qry = "SELECT 
				kal_cuti.id, 
				kal_cuti.tarikh, 
				kal_cuti.hari, 
				kal_cuti.cuti 
			FROM kal_cuti 
			WHERE kal_cuti.id ='$id'";
	
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$status = $row['status'];	
?>
<form id="entry_form" name="entry_form" method="post">
<div class="tajuk">&nbsp;</div>
<fieldset>
<legend>Cuti</legend>
<table width=100%>
	<tr><td width="120">Tarikh</td><td width="5">:</td><td><?php echo reverse($row['tarikh']) ?></td></tr>
	<tr><td width="120">Hari</td><td>:</td><td> <?php echo $row['hari'] ?></td></tr>
	<tr><td width="120">Jenis Cuti</td><td>:</td><td><?php echo $row['cuti'] ?></td></tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
</table>

</fieldset>
<br/>
<table width=100% border="0" style="margin-left:10px;">
	<tr><td>
	<input type="submit" value="KEMASKINI" name="EditCuti" class="button" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; }?>/>
	<input type="button" name="delete" value="HAPUS CUTI" onClick="delDoc('kalCuti','<?php echo $id;?>','')" class="button_del" <?php if($sys_acl!=1) echo 'disabled' ?>/>
	</td>
	</tr>
</table>

</form>
