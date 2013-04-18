<?php	
	
	$qry = "SELECT status,sesi_dewan,parlimen,penggal,mesyuarat,
			tkh_mula_bersidang,tkh_akhir_bersidang,perkara
			FROM parlimen WHERE id ='$id'" ;
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$status = $row['status'];	
	
?>

<form name="detail" method="post">
<fieldset><legend><b>Butir-butir Persidangan - Rekod Imbasan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  <td>	  </tr>
		<tr><td width=120>Sesi</td><td width=5>:</td><td width=250><?php echo ($row['sesi_dewan']==1)?"Dewan Rakyat":"Dewan Negara"; ?></td><td width=120>Mesyuarat</td><td width=5>:</td><td><?php echo $row['mesyuarat']?></td></td></tr>
		<tr><td width=120>Penggal</td><td width=5>:</td><td width=250><?php echo $row['penggal'] ?></td><td width=120>Parlimen</td><td width=5>:</td><td><?php echo $row['parlimen'] ?></td></td></tr>
		<tr><td width=120>Tarikh Persidangan</td><td width=5>:</td><td width=250><?php echo Reverse($row['tkh_mula_bersidang']) ?></td>
		<td width=120>Hingga</td><td width=5>:</td><td width=250><?php echo Reverse($row['tkh_akhir_bersidang']) ?></td></td></tr>
		<tr>
		  <td>Perkara</td>
		  <td>:</td>
		  <td colspan="5"><?php echo $row['perkara'] ?></td>
	  </tr>
		<tr><td width=120>Lampiran</td><td width=5>:</td><td colspan="5">
		<?php //display the attachments if any
		
		$qry = "SELECT * FROM parlimen_lampiran WHERE parlimen_id='$id' AND jawapan_id='0'";
		$res = mysql_query($qry,$conn);
		while($row = mysql_fetch_array($res)){
			$nama_fail = $row['nama_fail'];
			$path = "../parlimen/lampiran/$nama_fail";
			echo "<a href=\"\" onClick=\"window.open('$path','mywin');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br>";
		}
		
		?>		
		</td></tr>
	</table>	
</div> 
</fieldset>
 <?php if($sys_acl==1 && $isHEK){
echo "<input class=\"button\" type=\"submit\" value=\"KEMASKINI\" name=\"Edit_RekodLama\"/>";
} ?>
<input type="hidden" name="parlimen_id" value="<?php echo $_GET['id'] ?>"/>
<input type="hidden" name="jawapan_id" value=""/>

</form>
