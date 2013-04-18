		<tr><td width=145>Kawasan Parlimen</td>
			<td width=9>:</td>
			<td colspan=4><select name="Kawasan" id="Kawasan" onChange="submit()"><?php getKawasan1($kawasan_id,'1',$conn) ?></select>
		  <input type="hidden" name="kawasan_id" value="<?php echo ((!empty($kawasan_id))? $kawasan_id:'0') ?>"/></td></tr>
		<tr><td width=145>Nama Y.B</td>
			<td width=9>:</td>
			<td colspan=4><?php echo stripslashes($nama_yb) ?>
		  <input type="hidden" name="ahli_dewan_id" value="<?php echo ((!empty($ahli_dewan_id))? $ahli_dewan_id:'0');?>"/>
		  <input type="hidden" name="negeri" value="<?php echo ((!empty($negeri))? $kawasan_id:'0') ?>"/></td></tr>
