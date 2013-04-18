<?php 
$cari	= $_GET['carian'];
$sqlSearch	= "SELECT pengguna.nama, agensi.nama AS agensi 
				FROM pengguna, agensi
				WHERE 
					(pengguna.agensi_id = agensi.id) AND
					(pengguna.nama LIKE '%$cari%' OR pengguna.nokp LIKE '%$cari%')
				ORDER BY pengguna.nama ASC, agensi.agensi_id";
$sqlSearch	= "SELECT pengguna.*, agensi.nama AS agensi
				FROM pengguna
				LEFT JOIN agensi ON pengguna.agensi_id = agensi.id 
				WHERE 
					pengguna.nama LIKE '%$cari%' OR 
					pengguna.nokp LIKE '%$cari%'
				ORDER BY pengguna.nama ASC";
$rsSearch	= mysql_query($sqlSearch);
?>


<table width=100% border=0 cellspacing=1 style="border-collapse:collapse"> 
	<tr>
		<form action="redirect.php" method="post">
		<td colspan="5" align="right" valign="top">
			<input name="carian" type="text" class="txt" value="<?php echo $cari; ?>">
			<input type="submit" value="Cari" class="button"/>
		</td>
		</form>  
	</tr>
	<tr>
	  <td colspan="5"><strong>Keputusan Carian :</strong></td> 
  </tr>
	<tr>
		<th width="22%">Nama</th>
		<th width="11%">No.KP</th>
		<th width="21%">Agensi / Bahagian di Kementerian Kesihatan</th>
		<th width="20%">Jawatan</th>
	    <th width="26%">Emel</th>
	</tr>
	<?php 
		$i=0;
		while($rowSearch = mysql_fetch_array($rsSearch)){ 
		$rcolor = ($i%2)?'#B2DFEE':'#E7EFFF';
		?>
		<tr bgcolor="<?php echo $rcolor; ?>">
			<td class=rec><a href="index.php?action=details&id_tbl=<?php echo $rowSearch['id_tbl'];?>"><?php echo $rowSearch['nama'];?></a>&nbsp;</td>
			  <td class=rec><?php echo $rowSearch['nokp'];?></td>
			<td class=rec><?php echo $rowSearch['agensi'];?></td>
			<td class=rec><?php echo $rowSearch['jawatan'];?>&nbsp;</td>
		     <td class=rec><?php echo $rowSearch['emel'];?></td>
		</tr>
		<?php 
		$i++;
		}?>
</table>
