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
	
	function getKeyword($category,$default,$conn){
		$qry = "SELECT butiran FROM konfigurasi WHERE kategori = '$category' ORDER BY kod";
		$result = mysql_query($qry,$conn) or die(mysql_error());		
		while($row = mysql_fetch_array($result)){
			$item = $row['butiran'];
			$selected = ($item == $default)?"selected":"";
			echo "<option $selected>".$item."</option>";
		}
	}
	
	$sesi_dewan = ($_POST['Sesi'])?$_POST['Sesi']:$row['sesi_dewan'];
	$mesyuarat = ($_POST['Mesyuarat'])?$_POST['Mesyuarat']:$row['mesyuarat'];
	$penggal = ($_POST['Penggal'])?$_POST['Penggal']:$row['penggal'];
	$parlimen = ($_POST['Parlimen'])?$_POST['Parlimen']:$row['parlimen'];
			
	?>

<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>KALENDAR MESYUARAT <img src="../images/dot.gif"/></div>
<form id="entry_form" name="entry_form" method="post">
<fieldset><legend></legend>
<div class="sub">  </div>
</fieldset>

<fieldset>

<table width=100%>
		<tr>
		  <td>Mesyuarat</td>
		  <td>:</td>
		  <td><select name="Mesyuarat">
		    <?php getKeyword("Mesyuarat Parlimen",$mesyuarat,$conn) ?>
	      </select></td>
    </tr>
		<tr>
          <? //php echo $_GET['id'] ?>
          <td>Penggal</td>
          <td>:</td>
          <td><select name="Penggal">
              <?php getKeyword("Penggal Parlimen",$penggal,$conn) ?>
          </select></td>
    </tr>
		<tr>
          <td>Parlimen</td>
          <td>:</td>
          <td><p>
              <select name="Parlimen">
                <?php getKeyword("Sesi Parlimen",$parlimen,$conn) ?>
              </select>
            </p>
        </tr>
		<tr>
		  <td width=120>Sesi</td>
		  <td width=5>:</td>
		<td><p>
          <select name="Sesi">
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
