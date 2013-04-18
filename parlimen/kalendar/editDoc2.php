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
	//$tkh_mula_bersidang = ($_POST['TkhMulaBersidang'])?$_POST['TkhMulaBersidang']:adate($row['tkh_mula_bersidang']);
	//$tkh_akhir_bersidang = ($_POST['TkhAkhirBersidang'])?$_POST['TkhAkhirBersidang']:adate($row['tkh_akhir_bersidang']);
	//$bentuk_soalan = ($_POST['BentukSoalan'])?$_POST['BentukSoalan']:$row['BentukSoalan'];
	//$no_soalan = $_POST['NoSoalan']?$_POST['NoSoalan']:$row['no_soalan'];
	//$kawasan_id = $_POST['Kawasan']?$_POST['Kawasan']:$row['kawasan_id'];
	//$ahli_dewan_id = $_POST['ahli_dewan_id']?$_POST['ahli_dewan_id']:$row['ahli_dewan_id'];
	//$parti_id = $_POST['parti_id']?$_POST['parti_id']:$row['parti_id'];
	//$tkh_bentang_jawapan = $_POST['TkhBentang']?$_POST['TkhBentang']:adate($row['tkh_bentang_jawapan']);
	//$perkara = $_POST['Perkara']?$_POST['Perkara']:$row['perkara'];
	//$soalan = $_POST['Soalan']?$_POST['Soalan']:$row['soalan'];
	//$agensi = $_POST['Agensi']?$_POST['Agensi']:explode("+",$row['agensi']);
		
	
?>

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>KALENDAR MESYUARAT <img src="../images/dot.gif"/></div>
<form id="entry_form" name="entry_form" method="post">
<fieldset><legend></legend>
<div class="sub">  </div>
</fieldset>

<fieldset>

<table width=100%>
		<tr>
		<? //php echo $_GET['id'] ?> 
		  <td width=120>Penggal</td>
		  <td width=5>:</td>
		  <td><select name="Sesi">
		    <?php echo getSesiDewan($sesi_dewan) ?>
	      </select></td>
		</tr>
		<tr>
		  <td width=120>Parlimen</td>
		  <td width=5>:</td>
		  <td><p>

		      <select name="Parlimen">
		        <?php getKeyword("Sesi Parlimen",$parlimen,$conn) ?>
	        </select>
		  </p>
	      </tr>
		<tr>
		  <td>Mesyuarat</td>
		  <td>&nbsp;</td>
		  <td><select name="Mesyuarat">
		    <?php getKeyword("Mesyuarat Parlimen",$mesyuarat,$conn) ?>
	      </select></td>
    </tr>
		<tr>
		  <td width=120>Sesi</td>
		  <td width=5>:</td>
		<td><p>
          <select name="select">
            <?php echo getSesiDewan($sesi_dewan) ?>
          </select>
		</p>
		  </td></tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
    </tr>
	</table>
</fieldset>
<br/>
<input type="submit" value="Simpan" name="Simpan"/>
</form>
