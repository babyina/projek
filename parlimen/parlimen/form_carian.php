<?php
	//$cols = array("SesiDewan|Sesi Dewan","Penggal|Penggal","Mesyuarat|Mesyuarat",
	//"TkhMulaBersidang|Tarikh Mula Bersidang","TkhAkhirBersidang|Tarikh Akhir Bersidang",
	//"TkhBentang|Tarikh Dibentangkan","NoSoalan|No Soalan","BentukSoalan|Bentuk Soalan","Perkara|Perkara",
	//"KawasanParlimen|Kawasan Parlimen","AhliDewan|Nama Y.B","Parti|Wakil");
	
	$cols = array("sesi_dewan|Sesi Dewan","penggal|Penggal","mesyuarat|Mesyuarat",
	"tkh_mula_bersidang|Tarikh Mula Bersidang","tkh_akhir_bersidang|Tarikh Akhir Bersidang",
	"tkh_bentang_jawapan|Tarikh Dibentangkan","no_soalan|No Soalan","bentuk_soalan|Bentuk Soalan","perkara|Perkara",
	"kawasan_id|Kawasan Parlimen","ahli_dewan_id|Nama Y.B","parti_id|Wakil");
	?>
	<div class="box">
	<form name="borang" method="post" action="redirect2.php">
	<b>Carian Lengkap :</b>	
	<table border="1">
	<tr><td>
		<b>Isikan medan yang hendak dicari :</b>
		<table width="100%" border=1 style="border-style:double;border-color:#000000">
		<tr><td width="150">Sesi Dewan</td><td><select name="SesiDewan"><option selected="selected">semua</option>
		      <option value="2">Dewan Negara</option>
		      <option value="1">Dewan Rakyat</option>
		</select></td></tr>
		<tr><td width="150">Parlimen</td><td><select name="Parlimen"><option>semua</option><?php PrintOption($conn,$db_voffice,$query_parlimen);?></select></td></tr>
		<tr><td width="150">Penggal</td><td><select name="Penggal"><option>semua</option>			
						 <?php PrintOption($conn,$db_voffice,$query_penggal,"semua");?>
						 <?php PrintOption($conn,$db_voffice,$query_penggal,"","Dewan Negara");?>
		</select></td></tr>
		<tr><td width="150">Mesyuarat</td><td><select name="Mesyuarat"><option>semua</option>					
							<?php PrintOption($conn,$db_voffice,$query_mesyuarat,$_POST['Mesyuarat']);?>
							</select>			
						</td>
		</tr>
		<tr><td width="150">Bentuk Soalan </td>			
					<td><select name="BentukSoalan"><option>semua</option>
						 <?php PrintOption($conn,$db_voffice,$query_soalan); ?>
						</select>		
					</td>
		</tr>
		<tr><td>Perkara</td><td><input class="txt" type="text" name="Perkara" size="25"/></td></tr>
		<tr><td>Tahun</td><td><input class="txt" type="text" name="Tahun" size="10" maxlength="4"/></td></tr>
		<tr><td>Kawasan Parlimen</td><td>
		<select name="KawasanParlimen"><option value="semua" selected>semua</option><?php selectKawasan($conn,$db_voffice,"semua")?></select></td></tr>		
		</table>
	</td>
	<td>
	<b>Sila pilih medan yang hendak dipaparkan:</b><br/>
	<?php
	foreach($cols as $node){
		echo "<input type=\"checkbox\" name=\"column[]\" checked value='".str_replace("|","'>",$node)."<br/>";	
	}
	
	?>
	</td>
	</tr>
	</table>
	<br/><input class="button" type="submit" value="LIHAT KEPUTUSAN" name="KeputusanCarian"/>
	</form>
	</div>
