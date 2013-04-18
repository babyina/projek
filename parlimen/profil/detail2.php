<?php	
			
	$id = $_GET['id'];
	$qry = "SELECT ahli_parlimen.id,ahli_parlimen.sesi_dewan AS sesi,ahli_parlimen.nama AS nama_yb,
			ahli_parlimen.pangkat,ahli_parlimen.negeri,ahli_parlimen.status,ahli_parlimen.parti_id ,parti.nama_pendek as parti ,
			negeri.nama as negeri 
			FROM ahli_parlimen 
			LEFT JOIN parti ON parti.id = ahli_parlimen.parti_id 
			LEFT JOIN negeri ON negeri.id = ahli_parlimen.negeri 
			WHERE ahli_parlimen.id ='$id'" ;
				
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$status = $row['status'];	
			
?>

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>PROFIL AHLI DEWAN NEGARA <img src="../images/dot.gif"/></div>

<form name="detail" method="post">
<fieldset>
<div class="sub">
	<table border="0" width="100%">
		<tr><td width=144>Sesi</td><td width=15>:</td>
		<td width=518>Dewan Negara
		  <input type="hidden" name="Sesi" value="<?php echo $row['sesi'] ?>"/></tr>
		<tr><td width=144>Pangkat</td><td width=15>:</td><td width=518><?php echo stripslashes($row['pangkat']) ?></tr>
		<tr><td width=144>Nama YB </td><td width=15>:</td><td width=518><?php echo stripslashes($row['nama_yb']) ?></tr>
		<tr><td width=144>Negeri</td><td width=15>:</td><td width=518><?php echo $row['negeri'] ?></td></tr>
		<tr><td width=144>Parti Diwakili </td><td width=15>:</td><td width=518><?php echo $row['parti'] ?></td></tr>
</table>
</fieldset>

<p>
    <input type="hidden" name="ahli_parlimen_id" value="<?php echo $_GET['id'] ?>"/>
	<!--<input class="button" type="submit" value="KEMASKINI" name="Edit2"/>-->
	<input type="submit" value="KEMASKINI" name="Edit2" class="button" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; }?>/>
    <input type="button" name="delete" value="HAPUS" onClick="delDoc('negara','<?php echo $id;?>')" class="button" <?php if($sys_acl!=1) echo 'disabled' ?>/>    
</p>
</form>




  
