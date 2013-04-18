<?php 
$pgNum = 1;
$pgRow = 25;
if(isset($_GET['page'])){
	$pgNum = $_GET['page'];
}else
	$pgNum = 1;
$offset =($pgNum -1)*$pgRow;


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

$sesi_dewan = ($_POST['Sesi'])?$_POST['Sesi']:$row['sesi_dewan'];

?>

<BR>
<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div><br/>

<fieldset><form name="borang" method="post" action="lap_status.php" target="_blank">
<legend><b>Sila isikan butiran berikut <br/></b></legend>
<div class="sub">
<table border="0">
	<tr>
	  <td/>    
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>
	<tr><td width="0"/><td width="170">Sesi Dewan</td><td width="10">:</td><td width="488">
		<select name="Sesi"><?php echo getSesiDewan($sesi_dewan) ?></select></td></tr>
	<tr><td/><td>Tarikh Mula Persidangan </td><td>:</td><td><input class="txt" name="TkhMulaBersidang" size="15" value="<?php echo Reverse($tkh_mula_bersidang) ?>">
	    <a href='' onClick='popUpCalendar(this, borang.TkhMulaBersidang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a>&nbsp;</td></tr>
	<!--<tr><td width="15"/><td width="162">Parlimen</td><td width="10">:</td><td width="251">
		<select name="parlimen"><option/><?php PrintOption($conn,$db_voffice,$query_parlimen) ?></select></td></tr>
	<tr><td width="15"/><td width="162">Penggal</td><td width="10">:</td><td width="251">
		<select name="penggal"><option/><?php PrintOption($conn,$db_voffice,$query_penggal) ?></select></td></tr>
	<tr><td width="15"/><td width="162">Mesyuarat</td><td width="10">:</td><td width="251">
		<select name="mesyuarat"><option/><?php PrintOption($conn,$db_voffice,$query_mesyuarat) ?></select></td></tr>-->
</table>	
</div>

</fieldset>
&nbsp;&nbsp;<br>
<input  type="submit" value="CETAKAN PDF" class="button"/>
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
</form>

<?php } ?> 
