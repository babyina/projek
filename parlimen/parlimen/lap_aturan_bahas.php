<?php 

function adate($temp){
	return $temp;
}

function getSesiDewan($value){
	if($value==1)
		$val = "<option value=\"1\" selected>Dewan Rakyat</option><option value=\"2\">Dewan Negara</option>";
	else
		$val = "<option value=\"1\">Dewan Rakyat</option><option value=\"2\" selected>Dewan Negara</option>";
	return $val;
}

if($sys_acl<>1 || !($isHEK)){
	echo $acl_denied;
}else{ 	
?>

<body>
<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>LAPORAN STATUS<img src="../images/dot.gif"/></div>

<fieldset><form name="borang" method="post" action="lap_status_bahas.php" target="_blank">
<legend><b>Sila isikan butiran berikut <br/></b></legend>
<div class="sub">
<table border="0">
	<tr>
	  <td colspan="3">&nbsp;</td>    
	</tr>
	<tr><td width="170">Sesi Dewan</td><td width="10">:</td><td width="488">
		 <select name="Sesi"><option value="Dewan Rakyat">Dewan Rakyat</option><option value="Dewan Negara" selected>Dewan Negara</option>    </select></td></tr>
	<tr>
	  <td>Sehingga Tarikh </td><td>:</td><td><input class="txt" name="TkhMulaBersidang" size="15" value="<?php echo Reverse($tkh_mula_bersidang) ?>">
	    <a href='' onClick='popUpCalendar(this, borang.TkhMulaBersidang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a>&nbsp;</td></tr>
	<tr><td width="170">Parlimen</td><td width="10">:</td><td width="488">
		<select name="Parlimen"><option/><?php PrintOption($conn,$db_voffice,$query_parlimen) ?></select></td></tr>
	<tr><td width="170">Penggal</td><td width="10">:</td><td width="488">
		<select name="Penggal"><option/><?php PrintOption($conn,$db_voffice,$query_penggal) ?></select></td></tr>
	<tr><td width="170">Mesyuarat</td><td width="10">:</td><td width="488">
		<select name="Mesyuarat"><option/><?php PrintOption($conn,$db_voffice,$query_mesyuarat) ?></select></td></tr>
</table>	
</div>
</br>		

<input  type="submit" value="CETAKAN PDF" class="button"/>
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
</form>

</body>
<?php } ?>