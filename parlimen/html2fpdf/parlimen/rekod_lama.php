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
	
	$sesi_dewan = ($_POST['Sesi'])?$_POST['Sesi']:$row['sesi_dewan'];
	$mesyuarat = ($_POST['Mesyuarat'])?$_POST['Mesyuarat']:$row['mesyuarat'];
	$penggal = ($_POST['Penggal'])?$_POST['Penggal']:$row['penggal'];
	$parlimen = ($_POST['Parlimen'])?$_POST['Parlimen']:$row['parlimen'];
	$tkh_mula_bersidang = ($_POST['TkhMulaBersidang'])?$_POST['TkhMulaBersidang']:adate($row['tkh_mula_bersidang']);
	#$tkh_akhir_bersidang = ($_POST['TkhAkhirBersidang'])?$_POST['TkhAkhirBersidang']:adate($row['tkh_akhir_bersidang']);
	#$bentuk_soalan = ($_POST['BentukSoalan'])?$_POST['BentukSoalan']:$row['bentuk_saoalan'];
	#$no_soalan = $_POST['NoSoalan']?$_POST['NoSoalan']:$row['no_soalan'];
	#$kawasan_id = $_POST['Kawasan']?$_POST['Kawasan']:$row['kawasan_id'];
	#$ahli_dewan_id = $_POST['ahli_dewan_id']?$_POST['ahli_dewan_id']:$row['ahli_dewan_id'];
	#$parti_id = $_POST['parti_id']?$_POST['parti_id']:$row['parti_id'];
	#$tkh_bentang_jawapan = $_POST['TkhBentang']?$_POST['TkhBentang']:adate($row['tkh_bentang_jawapan']);
	$perkara = $_POST['Perkara']?$_POST['Perkara']:$row['perkara'];
	#$soalan = $_POST['Soalan']?$_POST['Soalan']:$row['soalan'];
	#$agensi = $_POST['Agensi']?$_POST['Agensi']:explode("+",$row['agensi']);
		
	if($_POST['Kawasan']){	
		$info_yb = getYB($_POST['Kawasan'],$conn);	
		$nama_yb = $info_yb[1];
		$ahli_dewan_id = $info_yb[0];
		$nama_parti = $info_yb[3];
		$parti_id = $info_yb[2];
	}else{
		$nama_yb = $row['nama_yb'];
		$ahli_dewan_id = $row['ahli_dewan_id'];
		$nama_parti = $row['parti'];
		$parti_id = $row['parti_id'];
	}

?>

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>SOAL JAWAB PARLIMEN<img src="../images/dot.gif"/></div>
<form enctype="multipart/form-data" action="index.php" method="post">
<fieldset><legend><b>Butir-butir Persidangan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr><td width=120>Sesi</td><td width=120>:</td><td width=250><select name="Sesi"><?php echo getSesiDewan($sesi_dewan) ?></select></td><td width=120>Mesyuarat</td><td width=5>:</td><td><select name="Mesyuarat"><?php getKeyword("Mesyuarat Parlimen",$mesyuarat,$conn) ?></select></td></td></tr>
		<tr><td width=120>Penggal</td><td width=120>:</td><td width=250><select name="Penggal"><?php getKeyword("Penggal Parlimen",$penggal,$conn) ?></select></td><td width=120>Parlimen</td><td width=5>:</td><td><select name="Parlimen"><?php getKeyword("Sesi Parlimen",$parlimen,$conn) ?></select></td></td></tr>
		<tr><td width=120>Tarikh Persidangan</td><td width=120>:</td><td width=250><input class="txt" name="TkhMulaBersidang" size="15" value="<?php echo $tkh_mula_bersidang ?>">&nbsp;<a href='' onClick='popUpCalendar(this, entry_form.TkhMulaBersidang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
		<td width=120>Hingga</td><td width=5>:</td><td width=250><input class="txt" name="TkhAkhirBersidang" size="15" value="<?php echo $tkh_akhir_bersidang ?>">&nbsp;<a href='' onClick='popUpCalendar(this, entry_form.TkhAkhirBersidang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td></td></tr>
		<tr><td width=120>Perkara</td><td width=120>:</td><td colspan=2><input name="Perkara" value="<?php echo $perkara?>" size=50 class="txt"/></td></tr>
		<tr><td width=120>Lampiran</td><td colspan="3"></td></tr>
		<tr>
	    <td colspan="4"><input id="my_file_element" type="file" name="file_1"></td></tr>
	</table>
	
	<div id="files_list"></div>
<script>
	<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
	var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 20 );
	<!-- Pass in the file element -->
	multi_selector.addElement( document.getElementById( 'my_file_element' ) );
</script>
</div>
</div>
</fieldset>

<!-- This is where the output will appear -->

<br/>
<input type="submit" value="Simpan" name="SubmitRekodLama"/>
</form>
