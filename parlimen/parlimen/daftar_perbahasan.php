<?php session_start();


	
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
?>


<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>SOAL JAWAB PARLIMEN<img src="../images/dot.gif"/></div>
<form id="daftar_form" name="daftar_form" method="post">
<fieldset>
<legend><b><center>Sesi Perbahasan </center></b></legend>
<div class="sub">
<table width="100%" border="0">
  <tr>
    <td width="22%">Tajuk</td>
    <td width="1%">:</td>
    <td width="77%"><select name="Tajuk" onChange="tajuk_type()">
      <option value="1" selected>Sesi Penggulungan Titah Ucapan Diraja</option>
      <option value="2">Sesi Penggulungan Perbahasan Bajet</option>
      <option value="3">Sesi Penggulungan Perbahasan Rang Undang-undang</option>
      <option value="4">Sesi Penggulungan Pembekalan Tambahan</option>
      <option value="5">Sesi Ucapan Penangguhan</option>
    </select></td>
  </tr>
    <tr>
    <td width="22%">Sesi Dewan</td>
    <td width="1%">:</td>
    <td width="77%"><select name="Sesi">
      <?php echo getSesiDewan($sesi_dewan) ?>
    </select></td>
  </tr>
    <tr>
    <td width="22%">Mesyuarat</td>
    <td width="1%">:</td>
    <td width="77%"><select name="Mesyuarat">
      <?php getKeyword("Mesyuarat Parlimen",$mesyuarat,$conn) ?>
    </select></td>
  </tr>
    <tr>
    <td width="22%">Penggal</td>
    <td width="1%">:</td>
    <td width="77%"><select name="Penggal">
      <?php getKeyword("Penggal Parlimen",$penggal,$conn) ?>
    </select></td>
  </tr>
    <tr>
    <td width="22%">Parlimen</td>
    <td width="1%">:</td>
    <td width="77%"><select name="Parlimen">
      <?php getKeyword("Sesi Parlimen",$parlimen,$conn) ?>
    </select></td>
  </tr>
    <tr>
    <td width="22%">Tarikh Mula </td>
    <td width="1%">:</td>
    <td width="77%"><input class="txt" name="TkhMulaBahas" size="15" value="<?php echo Reverse($tkh_mula_bersidang) ?>">&nbsp;<a href='' onClick='popUpCalendar(this, daftar_form.TkhMulaBahas, "dd/mm/yyyy");return false'>&nbsp;<img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
  </tr>
    <tr>
    <td width="22%">Tarikh Akhir </td>
    <td width="1%">:</td>
    <td width="77%"><input class="txt" name="TkhAkhirBahas" size="15" value="<?php echo Reverse($tkh_mula_bersidang) ?>">
      &nbsp;<a href='' onClick='popUpCalendar(this, daftar_form.TkhAkhirBahas, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
  </tr>
    <tr>
    <td width="22%">Tarikh Penggulungan</td>
    <td width="1%">:</td>
    <td width="77%"><input class="txt" name="TkhGulung" size="15" value="<?php echo Reverse($tkh_mula_bersidang) ?>">
      &nbsp;<a href='' onClick='popUpCalendar(this, daftar_form.TkhGulung, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
  </tr>
    <tr>
      <td>Tarikh Ucapan Penangguhan </td>
      <td>:</td>
      <td><input class="txt" name="TkhUcapan" size="15" value="<?php echo Reverse($tkh_mula_bersidang) ?>" disabled>
        &nbsp;<a href='' onClick='popUpCalendar(this, daftar_form.TkhUcapan, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
    </tr>
    <tr>
    <td width="22%">Nama Menteri/Timbalan Menteri/SUPAR</td>
    <td width="1%">:</td>
    <td width="77%"><select name="nama">
      <option value="1" selected>Nama Menteri</option>
      <option value="2">Nama Timbalan Menteri</option>
      <option value="3">Nama SUPAR</option>
    </select></td>
  </tr>

</table>

</div>
</fieldset><br>
<input type="button" value="Perkara Berbangkit" name="Perkara_Berbangkit" onClick="window.open('http://localhost/parlimen/parlimen/perkara_berbangkit.php','mywindow','width=1000,height=450')">
</form>