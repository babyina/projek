<head>
<script language="javascript">
	function explode(inputstring, separators, includeEmpties) {
		inputstring = new String(inputstring);
		separators = new String(separators);

		if(separators == "undefined") { 
		separators = " :;";
		}

		fixedExplode = new Array(1);
		currentElement = "";
		count = 0;
		for(x=0; x < inputstring.length; x++) {
			char = inputstring.charAt(x);
			if(separators.indexOf(char) != -1) {
			if ( ( (includeEmpties <= 0) || (includeEmpties == false)) && (currentElement == "")) { }
			else {
				fixedExplode[count] = currentElement;
				count++;
				currentElement = ""; } }
			else { currentElement += char; }
		}

			if (( ! (includeEmpties <= 0) && (includeEmpties != false)) || (currentElement != "")) {
				fixedExplode[count] = currentElement; 
			}
		return fixedExplode;
	}
</script>
</head>
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
		  <td width="120">Minggu</td>
		  <td width="5">:</td>
		  <td><select name="Minggu">
		      <option/>        
		      <?php PrintOption2($conn,$db_voffice,$query_minggu) ?>
		      </select></td>
    </tr>
		<tr>
		  <td>Tarikh</td>
		  <td>:</td>
		  <td><input name="Tarikh" size="15">
              <a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'kalendar_form.Tarikh',true,'dd/mm/yyyy');return false;"><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt=""></a> </td>
    </tr>
		<tr>
		  <td>Hari</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
    </tr>
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
