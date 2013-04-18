<?php
$Tajuk = ($_POST['Tajuk'])?$_POST['Tajuk']:$row['tajuk'];
$Mesyuarat = ($_POST['Mesyuarat'])?$_POST['Mesyuarat']:$row['mesyuarat'];
//$SubTajuk = ($_POST['SubTajuk'])?$_POST['SubTajuk']:$row['SubTajuk'];
$Penggal = ($_POST['Penggal'])?$_POST['Penggal']:$row['penggal'];
$Parlimen = ($_POST['Parlimen'])?$_POST['Parlimen']:$row['parlimen'];
$TarikhMula = ($_POST['TarikhMula'])?$_POST['TarikhMula']:$row['tkh_mula'];
$TarikhAkhir =($_POST['TarikhAkhir'])?$_POST['TarikhAkhir']:$row['tkh_akhir'];
$TarikhGulung =($_POST['TkhGulung'])?$_POST['TkhGulung']:$row['tkh_gulung'];
$Menteri = ($_POST['Menteri'])?$_POST['Menteri']:stripslashes($row['menteri']);
$sesi_dewan = ($_POST['SesiDewan'])?$_POST['SesiDewan']:$row['sesi'];

?>
<br />
<div class="subheader1"><center><img src="../images/dot.gif"/> SESI PERBAHASAN <img src="../images/dot.gif"/></center></div><br/>
<form name="bahas_form" method="post" action="index.php?id=<?php echo $id ?>" onSubmit="return validateRB(this)">
<fieldset><legend><b>Butir-butir Persidangan</b></legend>

	<div class="box" style="margin-left:5px"><br/>
		<table width="100%" border="0">
  <tr>
    <td width="3%">&nbsp;</td>
    <td width="28%">Tajuk</td>
    <td width="1%">:</td>
    <td width="68%"><select name="Tajuk">
      <option></option>
      <?php Keyword($conn,$query_tajuk,$db_voffice,$Tajuk); ?>
    </select></td>
  </tr>
    <tr>
      <td width="3%">&nbsp;</td>
    <td width="28%">Sesi Dewan</td>
    <td width="1%">:</td>
    <td width="68%">
      <?php echo getSesiDewanBahas($sesi_dewan) ?>
   </td>
  </tr>
    <tr>
      <td width="3%">&nbsp;</td>
    <td width="28%">Mesyuarat</td>
    <td width="1%">:</td>
    <td width="68%"><select name="Mesyuarat">
      <?php Keyword($conn,$query_mesyuarat,$db_voffice,$Mesyuarat);?>
    </select></td>
  </tr>
    <tr>
      <td width="3%">&nbsp;</td>
    <td width="28%">Penggal</td>
    <td width="1%">:</td>
    <td width="68%"><select name="Penggal">
      <?php Keyword($conn,$query_penggal,$db_voffice,$Penggal); ?>
    </select></td>
  </tr>
    <tr>
      <td width="3%">&nbsp;</td>
    <td width="28%">Parlimen</td>
    <td width="1%">:</td>
    <td width="68%"><select name="Parlimen">
      <?php Keyword($conn,$query_parlimen,$db_voffice,$Parlimen); ?>
    </select></td>
  </tr>
    <tr>
      <td width="3%">&nbsp;</td>
    <td width="28%">Tarikh Mula </td>
    <td width="1%">:</td>
    <td width="68%"><input name="TarikhMula" class="txt" id="TarikhMula" value="<?php echo Reverse($TarikhMula) ?>" size="15">
      <a href='' onClick='popUpCalendar(this, bahas_form.TkhMulaBahas, "dd/mm/yyyy");return false'></a><a href='' onClick='popUpCalendar(this, bahas_form.TarikhMula, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
  </tr>
    <tr>
      <td width="3%">&nbsp;</td>
    <td width="28%">Tarikh Akhir </td>
    <td width="1%">:</td>
    <td width="68%"><input name="TarikhAkhir" class="txt" id="TarikhAkhir" value="<?php echo Reverse($TarikhAkhir) ?>" size="15">
      <a href='' onClick='popUpCalendar(this, bahas_form.TarikhAkhir, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
  </tr>
    <tr>
      <td width="3%">&nbsp;</td>
    <td width="28%">Tarikh Penggulungan/Ucapan Penangguhan </td>
    <td width="1%">:</td>
    <td width="68%"><input class="txt" name="TkhGulung" size="15" value="<?php echo Reverse($TarikhGulung) ?>">
      <a href='' onClick='popUpCalendar(this, bahas_form.TkhGulung, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
  </tr>
    <tr>
      <td width="3%">&nbsp;</td>
    <td width="28%">Nama Menteri/Timbalan Menteri/SUPAR</td>
    <td width="1%">:</td>
    <td width="68%">
	<select name="Menteri"><?php displayWakil($Menteri,$conn)?></select>
	</td>
  </tr>

</table>
	</div>
</fieldset><br /><br/>
<input type="submit" value="SIMPAN" class="button" name="UpdateBahas"/>

</form>