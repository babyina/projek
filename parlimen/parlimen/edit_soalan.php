<script language="javascript">
	var soalan = 1;
	
function ben_soalan(val)
{
//alert(val);
document.getElementById("ben_sol").value=val;
	
if(val=='Bertulis')
{
//alert(val);
document.getElementById("sol_bertulis").style.display = 'none';

}
else
{
document.getElementById("sol_bertulis").style.display = '';
}


}	
	
</script>

<?php	 
	include("../js/FCKeditor/fckeditor.php"); 
	
	if($sys_acl>3 || !($isHEK)){ 
		echo $acl_denied;
	}else{	
	
	$sesi_dewan = ($_POST['Sesi'])?$_POST['Sesi']:$row['sesi_dewan'];
	$mesyuarat = ($_POST['Mesyuarat'])?$_POST['Mesyuarat']:$row['mesyuarat'];
	$penggal = ($_POST['Penggal'])?$_POST['Penggal']:$row['penggal'];
	$parlimen = ($_POST['Parlimen'])?$_POST['Parlimen']:$row['parlimen'];
	$tkh_mula_bersidang = ($_POST['TkhMulaBersidang'])?$_POST['TkhMulaBersidang']:adate($row['tkh_mula_bersidang']);
	$tkh_akhir_bersidang = ($_POST['TkhAkhirBersidang'])?$_POST['TkhAkhirBersidang']:adate($row['tkh_akhir_bersidang']);
	$bentuk_soalan = ($_POST['BentukSoalan'])?$_POST['BentukSoalan']:$row['bentuk_soalan'];
	$no_soalan = $_POST['NoSoalan']?$_POST['NoSoalan']:$row['no_soalan'];
	$kawasan_id = $_POST['Kawasan']?$_POST['Kawasan']:$row['kawasan_id'];
	$ahli_dewan_id = $_POST['ahli_dewan_id']?$_POST['ahli_dewan_id']:$row['ahli_dewan_id'];
	$parti_id = $_POST['parti_id']?$_POST['parti_id']:$row['parti_id'];
	$tkh_bentang_jawapan = $_POST['TkhBentang']?$_POST['TkhBentang']:adate($row['tkh_bentang_jawapan']);
	$tkh_jawab = $_POST['tkh_jawab']?$_POST['tkh_jawab']:adate($row['tkh_jawab']);
	$perkara = $_POST['Perkara']?$_POST['Perkara']:$row['perkara'];
	$soalan = $_POST['Soalan']? stripslashes($_POST['Soalan']) : stripslashes($row['soalan']);	
	$agensi = $_POST['Agensi']?$_POST['Agensi']:explode("+",$row['agensi']);
	$salinan = $_POST['salinan']?$_POST['salinan']:explode("+",$row['salinan']);		
	
	if($_POST['Sesi']){	
		if($_POST['Sesi']=="1"){
			if($_POST['Kawasan']){	
				$info_yb = getYB($_POST['Kawasan'],$conn);	
				$nama_yb = stripslashes($info_yb[1]);
				$ahli_dewan_id = $info_yb[0];
				$nama_parti = $info_yb[3];
				$parti_id = $info_yb[2];
				$fullname = $nama_yb;
				$soalan = "";
				//echo $nama_yb.$ahli_dewan_id.$nama_parti.$parti_id;
			}
		}
		else{
			if($_POST['AhliDewan']){
				$ahli_dewan_id = stripslashes($_POST['AhliDewan']);
				$info = getKawasanYB($_POST['AhliDewan'],$conn);	
				$nama_yb = $info[0];
				$negeri = stripslashes($info[1]);
				$negeri_nama = $info[1]; //negeri
				$parti_id = $info[2];
				$nama_parti = $info[3];				
				$negeri_id = $info[4];				
				$fullname = $info[5]." ".$nama_yb; //pangkat + nama
				$soalan = "";
			}
		}
			
	}else{
		$nama_yb = stripslashes($row['nama_yb']);
		$ahli_dewan_id = $row['ahli_dewan_id'];
		$nama_parti = $row['parti'];
		$parti_id = $row['parti_id'];
		$negeri_id = $row['negeri_id'];
		$negeri_nama = $row['negeri_nama'];
	}
	
	if(empty($soalan) && !empty($fullname)){
		$namaYB = ucwords(stripslashes($fullname)); 
		if($_POST['Kawasan']!='')
		{
		$query_kawasan 	= "SELECT nama FROM kawasan WHERE id='".$_POST['Kawasan']."'"; 
		mysql_select_db($db_voffice,$conn) or die(mysql_error());
		$result_kawasan = mysql_query($query_kawasan,$conn) or die(mysql_error());

		$row_kawasan= mysql_fetch_array($result_kawasan);
		$n_kawasan = "[ ".$row_kawasan['nama']." ]";
		}
		else
		{
		$n_kawasan = "";
		}
		
		$soalan = "<strong>".$namaYB." ".$n_kawasan." </strong> minta <strong>MENTERI KESIHATAN</strong> menyatakan ";
		//$soalan = $row['soalan'];
		//echo $soalan; 
		}
?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<br />
<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div><br/>
<form id="entry_form" enctype="multipart/form-data" name="entry_form" method="post" onSubmit="if(toValidate) return validateForm(this); if(simpan) return validateFormSimpan(this)">
<fieldset style="width:auto "><legend><b>Butir-butir Persidangan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr><td width=179>Sesi</td>
		<td width=10>:</td>
		<td width=782>		  <?php echo getSesiDewan($sesi_dewan) ?>
        <input type="hidden" name="dewan_" id="dewan_" value="<?php echo $_POST['Sesi'];?>"/></td>
		</tr>
		<tr>
		  <td> Mesyuarat</td>
		  <td> :</td>
		  <td><select name="Mesyuarat">
		      <?php getKeyword("Mesyuarat Parlimen",$mesyuarat,$conn) ?>
		      </select></td>
	  </tr>
		<tr><td width=179>Penggal</td>
		<td width=10>:</td>
		<td width=782><select name="Penggal"><?php getKeyword("Penggal Parlimen",$penggal,$conn) ?></select></td></tr>
		<tr>
		  <td>Parlimen</td>
		  <td>:</td>
		  <td><select name="Parlimen">
		      <?php getKeyword("Sesi Parlimen",$parlimen,$conn) ?>
		      </select></td>
	  </tr>
		<tr>
		  <td width=179>Tarikh Mula Persidangan <span class="style1">*</span></td>
		  <td width=10>:</td>
		<td width=782><input class="txt" name="TkhMulaBersidang" size="15" value="<?php echo Reverse($tkh_mula_bersidang) ?>">&nbsp;<a href='' onClick='popUpCalendar(this, entry_form.TkhMulaBersidang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" align="absmiddle" name="imgCalendar1" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
		</tr>
		<tr>
		  <td>Tarikh Akhir Persidangan</td>
		  <td>:</td>
		  <td><input class="txt" name="TkhAkhirBersidang" size="15" value="<?php echo Reverse($tkh_akhir_bersidang) ?>">
<a href='' onClick='popUpCalendar(this, entry_form.TkhAkhirBersidang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" align="absmiddle" name="imgCalendar2" width="34" height="21" border="0" alt="Pilih Tarikh"></a></td>
	  </tr>
	</table>
</div>
</fieldset>
<br />
<br>
<fieldset style="width:auto "><legend><b>Butir-butir Soalan</b></legend>
	<table width=100%>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td></td>
	  </tr>
	<tr><td width=178>Bentuk Soalan</td>
		<td width=3>:</td>
		<td width=395><?php echo getBentukSoalan($bentuk_soalan) ?></td> 
		<td width=128>&nbsp;</td>
		<td width=10>&nbsp;</td>
		<td width="220">&nbsp;</td>
		<td width="19"></td>
	</tr>
	<tr>
		<td>No. Soalan <span class="style1">* </span></td>
		<td>:</td>
		<td colspan=4><input class="txt" onBlur="checkNumeric(this,'','','','','');" name="NoSoalan" size=15 value="<?php echo $no_soalan ?>"/></td>
	</tr>
	<?php
	
	if($_POST['Sesi']) // newdoc 
	{
		if($_POST['Sesi']=="2"){
			include("dn_edit.php");
		}else{
			include("dr_edit.php");
		}
	}
	elseif(!empty($sesi_dewan)) //from kemaskini 
	{
		if($sesi_dewan=="2"){
			include("dn_edit.php");
		}else{
			include("dr_edit.php");
		}
	}	
	else
		include("dr_edit.php");
	?>		
	<tr><td width=178>Wakil</td>
			<td width=3>:</td>
			<td colspan=4><?php echo $nama_parti ?>
		  <input type="hidden" name="parti_id" id="parti_id" value="<?php echo ((!empty($parti_id))? $parti_id:'0');?>"/>
		  <input type="hidden" name="kawasan_id" value="<?php echo ((!empty($parti_id))? $kawasan_id:'0');?>"/>
           <input type="hidden" name="ben_sol" id="ben_sol" value="Lisan"/>
		  </td></tr>
		<tr id="sol_bertulis" style="display:<?php if($bentuk_soalan=='Lisan'){echo '';} else if($bentuk_soalan=='Bertulis') {echo 'none';} else {echo '';}?>">
			<td width=178><strong>Tarikh  Jawab Soalan Di Parlimen</strong><span class="style1">*</span> </td>
		  <td width=3>:</td>
			<td colspan=4><input class="txt" name="TkhBentang" size="15" value="<?php echo Reverse($tkh_bentang_jawapan) ?>">&nbsp;<a href='' onClick='popUpCalendar(this, entry_form.TkhBentang, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="imgCalendar3" width="34" height="21" border="0" alt="Pilih Tarikh"></a>		</td></tr>
		<tr><td width=178>Perkara</td>
			<td width=3>:</td>
			<td colspan=4><textarea name="Perkara" cols="90" rows="2" class="txt"><?php echo $perkara?></textarea></td></tr>
		<tr>
			<td width=178 valign=top>Soalan</td>
			<td width=3>:</td>
			<td colspan=4><?php createRTF($sBasePath, 'Soalan', $soalan);?></td>
		</tr>
		</td>
		</tr>
		<!--<tr> start here 08/02/2010
		  <td>Lampiran</td>
		  <td>:</td>
		  <td colspan=4><input id="my_file_element" type="file" name="file_1">
		    <br /><?php //display the attachments if any	
		$qry = "SELECT * FROM soalan_lampiran WHERE parlimen_id='$id'";
		$res = mysql_query($qry,$conn);
		while($row2 = mysql_fetch_array($res)){
			$nama_fail = $row2['nama_fail'];
			$path = "../parlimen/lampiran/$nama_fail";
			echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a><br>";
		}
		?></td>
	  </tr> end here 08/02/2010-->
	 <!--  <tr>
  			<td>&nbsp;</td>	 
  			<td>&nbsp;</td>
   			<td colspan=4><!-- This is where the output will appear -->
       <!--         <div id="files_list"></div>
                <script>
				<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
				<!--var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 10 );
				<!-- Pass in the file element -->
				<!--multi_selector.addElement( document.getElementById( 'my_file_element' ) );
				</script></td>
  </tr>-->
		<tr valign="top">
		  <td><strong>Jawapan  hendaklah sampai ke Urusetia Penyelarasan Parlimen KKM sebelum</strong>:<br /> </td>
		  <td>:</td>
		  <td colspan=4><input class="txt"  type="text" name="tkh_jawab" size="15" value="<?php echo Reverse($tkh_jawab) ?>">
	      <a href='' onclick='popUpCalendar(this, entry_form.tkh_jawab,"dd/mm/yyyy");return false'><img src="../images/calendar.gif" align="absmiddle" alt="Pilih Tarikh" name="imgCalendar4" width="34" height="21" border="0" id="imgCalendar" /></a></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan=4>&nbsp;</td>
	  </tr>
		<tr>
		  <td>Untuk Tindakan </td>
		  <td>:</td>
		  <td colspan=4><table width="100%" border="0">
            <tr>
              <td width="59%"><strong>Bahagian di Kementerian Kesihatan : </strong><br><?php getAgensi($agensi,$conn,"Bahagian Kementerian Kesihatan")?></td>
              <td width="41%"><strong>Agensi : </strong><br><?php getAgensi($agensi,$conn,"Agensi") ?></td>
            </tr>
          </table></td>
		</tr>
		<tr>
		  <td width=178>&nbsp;</td>
		<td width=3>&nbsp;</td>
		<td colspan=4>&nbsp;</td>
		</tr>
		<!--<tr><td width=178>Salinan Kepada</td>
		<td width=3>:</td>
		<td colspan=3>
			<?php 
			//$ap	= lookup($conn, 'konfigurasi', 'butiran', "kategori='Anggota Pentadbiran'");
			//$key = $keyword[20];
			//getSalinan($salinan,$key,$conn);
			
			?>			
			<div style="font-family:Geneva, Arial, Helvetica, sans-serif; font-size:10px">
				<!--[Nota: Anggota Pentadbiran terdiri daripada <strong><?php //echo $ap; ?></strong>]-->
			</div>
		<!--</td>
		<td>&nbsp;</td>
		</tr>-->
	</table>
</fieldset>
<br/>
<input class="button" type="hidden" value="1" name="Refresh"/>
<input class="button" type="submit" value="SIMPAN" name="SubmitDraf" onClick="toValidate=true;simpan=false"/>
<input class="button" type="submit" value="SIMPAN & HANTAR" name="SubmitSoalan" onClick="toValidate=true;simpan=false"/>
<!--<input class="button" type="submit" value="SIMPAN & HANTAR" name="SubmitSoalan" onClick="toValidate=true;simpan=false"/>-->
</form>

<?php } ?>
<!-- jamlee edited -->
