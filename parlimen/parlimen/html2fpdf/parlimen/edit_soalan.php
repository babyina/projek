<?php	

	function Reverse($date){ 
	if(!empty($date))
	{
	$result = (strpos($date,"-"));
	
	if($date == "0000-00-00")
		return $date="";
	if($result === false)
	{
		return $date;	
	}
	else{		
 	   	 $temp = array();
 	   	 $temp =  explode("-",$date); 
	   	 $temp2 = array($temp[2], $temp[1], $temp[0]);
		 $date = implode("/", $temp2);
	     return $date;		
	}	
	}
	}
	
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
	$tkh_akhir_bersidang = ($_POST['TkhAkhirBersidang'])?$_POST['TkhAkhirBersidang']:adate($row['tkh_akhir_bersidang']);
	$bentuk_soalan = ($_POST['BentukSoalan'])?$_POST['BentukSoalan']:$row['BentukSoalan'];
	$no_soalan = $_POST['NoSoalan']?$_POST['NoSoalan']:$row['no_soalan'];
	$kawasan_id = $_POST['Kawasan']?$_POST['Kawasan']:$row['kawasan_id'];
	$ahli_dewan_id = $_POST['ahli_dewan_id']?$_POST['ahli_dewan_id']:$row['ahli_dewan_id'];
	$parti_id = $_POST['parti_id']?$_POST['parti_id']:$row['parti_id'];
	$tkh_bentang_jawapan = $_POST['TkhBentang']?$_POST['TkhBentang']:adate($row['tkh_bentang_jawapan']);
	$perkara = $_POST['Perkara']?$_POST['Perkara']:$row['perkara'];
	$soalan = $_POST['Soalan']?$_POST['Soalan']:$row['soalan'];
	$agensi = $_POST['Agensi']?$_POST['Agensi']:explode("+",$row['agensi']);
	$salinan = $_POST['salinan']?$_POST['salinan']:explode("+",$row['salinan']);		
		
	if($_POST['Kawasan']){	
		$info_yb = getYB($_POST['Kawasan'],$conn);	
		$nama_yb = $info_yb[1];
		$ahli_dewan_id = $info_yb[0];
		$nama_parti = $info_yb[3];
		$parti_id = $info_yb[2];
		#echo $nama_yb.$ahli_dewan_id.$nama_parti.$parti_id;
	}else{
		$nama_yb = $row['nama_yb'];
		$ahli_dewan_id = $row['ahli_dewan_id'];
		$nama_parti = $row['parti'];
		$parti_id = $row['parti_id'];
	}

?>

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>SOAL JAWAB PARLIMEN<img src="../images/dot.gif"/></div>
<form id="entry_form" name="entry_form" method="post">
<fieldset><legend><b>Butir-butir Persidangan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr><td width=120>Sesi</td><td width=5>:</td><td width=250><select name="Sesi"><?php echo getSesiDewan($sesi_dewan) ?></select></td><td width=120>Mesyuarat</td><td width=5>:</td><td><select name="Mesyuarat"><?php getKeyword("Mesyuarat Parlimen",$mesyuarat,$conn) ?></select></td></td></tr>
		<tr><td width=120>Penggal</td><td width=5>:</td><td width=250><select name="Penggal"><?php getKeyword("Penggal Parlimen",$penggal,$conn) ?></select></td><td width=120>Parlimen</td><td width=5>:</td><td><select name="Parlimen"><?php getKeyword("Sesi Parlimen",$parlimen,$conn) ?></select></td></td></tr>
		<tr><td width=120>Tarikh Persidangan</td><td width=5>:</td><td width=250><input class="txt" name="TkhMulaBersidang" size="15" value="<?php echo Reverse($tkh_mula_bersidang) ?>">&nbsp;<a href='' onClick='popUpCalendar(this, entry_form.TkhMulaBersidang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
		<td width=120>Hingga</td><td width=5>:</td><td width=250><input class="txt" name="TkhAkhirBersidang" size="15" value="<?php echo Reverse($tkh_akhir_bersidang) ?>">&nbsp;<a href='' onClick='popUpCalendar(this, entry_form.TkhAkhirBersidang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td></td></tr>
	</table>
</div>
</fieldset>

<fieldset><legend><b>Butir-butir Soalan</b></legend>
	<table width=100%>
		<tr><td width=120>Bentuk Soalan</td><td width=5>:</td><td width=250><select name="BentukSoalan"><?php getBentukSoalan($bentuk_soalan)?></select></td><td width=120>No. Soalan</td><td width=5>:</td><td><input class="txt" name="NoSoalan" size=20 value="<?php echo $no_soalan ?>"/></td></td></tr>
		<tr><td width=120>Kawasan Parlimen</td><td width=5">:</td><td colspan=4><select name="Kawasan" onChange="submit()"><?php getKawasan($kawasan_id,$conn) ?></select><input type="hidden" value="<?php echo $kawasan_id ?>" name="kawasan_id"/></td></tr>
		<tr><td width=120>Nama Y.B</td><td width=5">:</td><td colspan=4><?php echo $nama_yb ?><input type="hidden" name="ahli_dewan_id" value="<?php echo $ahli_dewan_id ?>"></td></tr>
		<tr><td width=120>Wakil</td><td width=5">:</td><td colspan=4><?php echo $nama_parti; echo $parti_id?><input type="hidden" name="parti_id" value="<?php echo $parti_id ?>"/></td></tr>
		<tr>
		  <td width=120>Tarikh Jawapan Akan Dibentang</td>
		  <td width=5">:</td>
		<td colspan=4><input class="txt" name="TkhBentang" size="15" value="<?php echo Reverse($tkh_bentang_jawapan) ?>">&nbsp;<a href='' onClick='popUpCalendar(this, entry_form.TkhBentang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a>
		</td></tr>
		<tr><td width=120>Perkara</td><td width=5">:</td><td colspan=4><input name="Perkara" value="<?php echo $perkara?>" size=50 class="txt"/></td></tr>
		<tr><td width=120 valign=top>Soalan</td><td width=5">:</td><td colspan=4><textarea name="Soalan" rows="10" cols="50" class="txt"><?php echo $soalan?></textarea></td></tr>
		<tr><td width=120>Untuk Tindakan (Jabatan/Agensi)</td><td width=5">:</td><td colspan=4><?php getAgensi($agensi,$conn) ?></td></tr>
		<tr><td width=120>Salinan Kepada</td><td width=5">:</td><td colspan=4><?php getSalinan($salinan,$conn) ?></td>
		</tr>
	</table>
</fieldset>
<br/>
<input type="hidden" value="1" name="Refresh"/>
<input type="submit" value="Simpan" name="SubmitDraf"/>
<input type="submit" value="Simpan & Hantar" name="SubmitSoalan"/>
</form>
