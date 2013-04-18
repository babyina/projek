<fieldset>
	<legend><b><?php echo $namatag.$penyemak1 ?>  </b></legend>
	<div class="sub">
		<table border=0 width="100%"> 
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr><td width=200>Nama Pegawai</td><td width=10>:</td><td colspan="2"><?php if (!empty($nama1))echo $nama1?></td><td width="29"></td></tr>
			<tr><td width=200>Jawatan</td><td width=10>:</td><td colspan="2"><?php if (!empty($nama1)) echo $penyemak1 ?></td></td></tr>
		  
			<tr>
			  <td width=200>
			  Status</td>
			  <td width=10>:</td>           
			  <td>
		      <?php if (!empty($nama1)) echo $tagstatus; ?>
		     <?php //echo "telah semak" ?></td>
			  <td>&nbsp;</td>
			</tr>												
             <?php  if(!empty($catatan1)) {?>
			<tr >
			  <td valign="top">Catatan Pindaan </td>
			  <td valign="top">:</td>
			  <td valign="top" id="Pengurusan_Catatan"><textarea name="Pengurusan_Catatan" rows=6 cols=60><?php echo $catatan1 ?></textarea>            
			            
		 <!-- <tr  >
		    <td width=200>Pindaan/Pertanyaan</td><td width=10>:</td>			  
		    <td width="156">		                  
		    <td width="568">
			</tr> -->
  	   <?php
				//$cat = "Pengesahan Parlimen";
				//getSemakanParlimen2($conn,$cat);	
				?> 			 	
	</td></tr>
	<?php }?>
		</table>
<br />
	</div>
	</fieldset>

			

	<br /><br />
	
