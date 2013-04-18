<?php
if($sys_acl==4 || !($isCalUser)){
	echo $acl_denied;
}else{

if($_GET['action']!='newdocCuti'){
	$id = $_GET['id'];
	
	$qry = "SELECT kal_cuti.id, kal_cuti.tarikh, kal_cuti.hari, kal_cuti.cuti FROM kal_cuti
			WHERE kal_cuti.id ='$id'";
	
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$status = $row['status'];						
}
?>

<script language="javascript">

	function findHari(obj){
		var hari = ["Ahad","Isnin","Selasa","Rabu","Khamis","Jumaat","Sabtu"];	
		var dat = explode(obj.tarikh.value,"/",true);
		var tkh = new Date(dat[2],dat[1]-1,dat[0]);				
		obj.hari.value = hari[tkh.getDay()];
	}	
	
</script>
<form id="frm_cuti" name="frm_cuti" method="post" onSubmit="return validateForm(this)">
<div class="tajuk">&nbsp;</div>
<fieldset>
<legend>Cuti </legend>
<br>
<table width=100%>
		<tr><td width="120">Tarikh </td><td width="5">:</td><td><input name="tarikh" class="txt" value="<?php echo reverse($row['tarikh']) ?>" size="15" onBlur="findHari(document.frm_cuti)">&nbsp;<img src="../images/calendar.gif" name="imgCalendar" border="0" alt="" onClick='popUpCalendar(this, frm_cuti.tarikh, "dd/mm/yyyy");return false' align="absmiddle"></td></tr>
		<tr><td width="120">Hari</td><td>:</td><td><input name="hari" value="<?php echo $row['hari'] ?>" size=50 class="txt" onFocus="blur()"/></td></tr>
		<tr><td width="120">Jenis Cuti </td><td>:</td><td><p><input name="cuti" value="<?php echo $row['cuti'] ?>" size=50 class="txt"/></p></tr>
</table>
<br/>
</fieldset>
<table width=100% border="0" style="margin-left:10;">
	<tr><td><input type="submit" value="SIMPAN" name="SimpanCuti" class="button" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; }?>/>
	  <input type="button" name="delete" value="HAPUS CUTI" onClick="delDoc('kalCuti','<?php echo $id;?>','')" class="button_del" <?php if($sys_acl!=1) echo 'disabled' ?>/></td></tr>
</table>
</form>
<?php }?>