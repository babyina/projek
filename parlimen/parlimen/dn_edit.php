		<tr><td width=145>Nama Y.B Senator</td>
			<td width=9>:</td>
			<td colspan=4><select name="AhliDewan" onChange="submit()"><?php PrintYBSenator($ahli_dewan_id,$sesi_dewan,$conn,$db_voffice)  ?></select>
		  <input type="hidden" name="ahli_dewan_id" value="<?php echo ((!empty($ahli_dewan_id))? $ahli_dewan_id:'0');?>"/></td></tr>
		<tr><td width=145>Negeri</td>
			<td width=9>:</td>
			<td colspan=4><?php echo $negeri_nama ?>
		  <input type="hidden" name="negeri_id" value="<?php echo ((!empty($negeri_id))? $negeri_id:'0') ?>"/></td></tr>
		  <input type="hidden" name="kawasan_id" value="<?php echo ((!empty($kawasan_id))? $kawasan_id:'0') ?>"/>
