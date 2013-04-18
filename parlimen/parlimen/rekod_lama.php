<?php	

	if($sys_acl<>1 || !($isHEK)){
		echo $acl_denied;
	}else{	
	
	$sesi_dewan = ($_POST['Sesi'])?$_POST['Sesi']:$row['sesi_dewan'];
	$mesyuarat = ($_POST['Mesyuarat'])?$_POST['Mesyuarat']:$row['mesyuarat'];
	$penggal = ($_POST['Penggal'])?$_POST['Penggal']:$row['penggal'];
	$parlimen = ($_POST['Parlimen'])?$_POST['Parlimen']:$row['parlimen'];
	$tkh_mula_bersidang = ($_POST['TkhMulaBersidang'])?$_POST['TkhMulaBersidang']:adate($row['tkh_mula_bersidang']);
	$tkh_akhir_bersidang = ($_POST['TkhAkhirBersidang'])?$_POST['TkhAkhirBersidang']:adate($row['tkh_akhir_bersidang']);
	#$bentuk_soalan = ($_POST['BentukSoalan'])?$_POST['BentukSoalan']:$row['bentuk_saoalan'];
	#$no_soalan = $_POST['NoSoalan']?$_POST['NoSoalan']:$row['no_soalan'];
	#$kawasan_id = $_POST['Kawasan']?$_POST['Kawasan']:$row['kawasan_id'];
	#$ahli_dewan_id = $_POST['ahli_dewan_id']?$_POST['ahli_dewan_id']:$row['ahli_dewan_id'];
	#$parti_id = $_POST['parti_id']?$_POST['parti_id']:$row['parti_id'];
	#$tkh_bentang_jawapan = $_POST['TkhBentang']?$_POST['TkhBentang']:adate($row['tkh_bentang_jawapan']);
	$perkara = $_POST['Perkara']?$_POST['Perkara']:$row['perkara'];
	#$soalan = $_POST['Soalan']?$_POST['Soalan']:$row['soalan'];
	#$agensi = $_POST['Agensi']?$_POST['Agensi']:explode("+",$row['agensi']);
	$parlimen_id=$_GET['id'];
		
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
	
if ($Hapus){
		        
				$qry3 	= "DELETE FROM parlimen_lampiran WHERE lampiran_id='$l_id'";
				mysql_query($qry3,$conn) or die(mysql_error());
				}
?>

<div style="font-family:Arial;font-size:9pt;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></div>
<form name="olddoc" enctype="multipart/form-data" action="" method="post">
<fieldset><legend><b>Butir-butir Persidangan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td></td>
	  </tr>
		<tr><td width=118>Sesi</td>
		<td width=13>:</td>
		  <td width=349><?php echo getSesiDewanImbasan($sesi_dewan) ?></td>
		  <td width=118>Mesyuarat</td>
		  <td width=16>:</td>
		  <td><select name="Mesyuarat"><?php getKeyword("Mesyuarat Parlimen",$mesyuarat,$conn) ?></select></td><td width="79"></td>
		</tr>
		<tr><td width=118>Penggal</td>
		<td width=13>:</td>
		<td width=349><select name="Penggal"><?php getKeyword("Penggal Parlimen",$penggal,$conn) ?></select></td><td width=118>Parlimen</td>
		<td width=16>:</td>
		<td><select name="Parlimen"><?php getKeyword("Sesi Parlimen",$parlimen,$conn) ?></select></td></td></tr>
		<tr><td width=118>Tarikh Persidangan</td>
		<td width=13>:</td>
		<td width=349><input class="txt" name="TkhMulaBersidang" size="15" value="<?php echo $tkh_mula_bersidang ?>">&nbsp;<a href='' onClick='popUpCalendar(this, olddoc.TkhMulaBersidang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
		<td width=118>Hingga</td>
		<td width=16>:</td>
		<td width=233><input class="txt" name="TkhAkhirBersidang" size="15" value="<?php echo $tkh_akhir_bersidang ?>">&nbsp;<a href='' onClick='popUpCalendar(this, olddoc.TkhAkhirBersidang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td></td></tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan=7>&nbsp;</td>
	  </tr>
		<tr><td width=118>Perkara</td>
		<td width=13>:</td>
		<td colspan=7><input name="Perkara" value="<?php echo $perkara?>" size=70 class="txt"/></td></tr>
		<tr><td width=118>Lampiran</td>
		<td colspan="7">:
		  <input id="my_file_element" type="file" name="file_1" class="button" /></td>
		</tr>
		<tr>
		<td>&nbsp;		</td>
	    <td colspan="6">
			<div id="files_list"></div>
                <script>
				<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
				var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 10 );
				<!-- Pass in the file element -->
				multi_selector.addElement( document.getElementById( 'my_file_element' ) );
				</script>
				<?php //display the attachments if any
		
		$qry = "SELECT * FROM parlimen_lampiran WHERE parlimen_id='$id' AND jawapan_id='0'";
		$res = mysql_query($qry,$conn);
		while($row = mysql_fetch_array($res)){
			$nama_fail = $row['nama_fail'];
			$lampiran_id = $row['lampiran_id'];
			$path = "../parlimen/lampiran/$nama_fail";
			
			
			echo "<tr><td><a href=\"\" onClick=\"window.open('$path','mywin');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br></td>";
			echo "<td><input type=\"submit\" value = \"Hapus\" name=\"Edit_RekodLama\" class=\"button\"/></td>";
			echo "<input type=\"hidden\" name=\"lampiran_id\" value=\"$lampiran_id\"/>";
			
			
			
		}
		
		
		?>	
		</td>
		</tr>
	</table>
	

</fieldset>

<!-- This is where the output will appear -->

<br/><br/>
<div class="sub" align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input class="button" type="submit" value="SIMPAN" name="SubmitRekodLama"/></div>
<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>
</form>
<?php } ?>